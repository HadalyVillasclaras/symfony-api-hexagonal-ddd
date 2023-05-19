<?php

declare(strict_types=1);

namespace App\Tests\Unit\MyDashboard\books\Application;

use App\MyDashboard\books\Application\book\AddBookRequest;
use App\MyDashboard\books\Application\book\Addbookservice;
use App\MyDashboard\books\Domain\Exceptions\DuplicatedBookByLegacyBookIdException;
use App\MyDashboard\books\Domain\book;
use App\MyDashboard\books\Domain\booksurvey;
use App\MyDashboard\books\Domain\BookText;
use App\MyDashboard\books\Domain\BookTextReply;
use App\MyDashboard\books\Infrastructure\InMemoryBookRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

final class AddbookserviceTest extends TestCase
{
    private InMemoryBookRepository $bookRepository;

    public function setUp(): void
    {
        $this->bookRepository = new InMemoryBookRepository();
    }

    public function testValidAddBook(): void
    {
        $params = json_decode(
            '{
                "legacyBookingId": 12345,
                "legacyPropertyId": 1681,
                "status": true,
                "userId": 1212,
                "originalLanguage": "es",
                "originalReplyLanguage": "es",
                "statusReply": true,
                "isFake": false,
                "isExternal": false,
                "isPending": false,
                "isHidden": false,
                "customerName": "Paco",
                "customerCity": "Málaga",
                "customerCountry": "ES",
                "customerLanguage": "es",
                "bookTexts": [
                    {
                        "language": "fr",
                        "text": "De belles vacances dans une belle villa"
                    },
                    {
                        "language": "de",
                        "text": "Ein toller Urlaub in einer wunderschönen Villa"
                    },
                    {
                        "language": "nl",
                        "text": "Een geweldige vakantie in een prachtige villa"
                    },
                    {
                        "language": "en",
                        "text": "A great vacation in a beautiful villa"
                    },
                    {
                        "language": "es",
                        "text": "Muchas gracias por su valoración. Ha sido un placer."
                    }
                ],
                "bookTextReply": [
                    {
                        "language": "es",
                        "text": "Orci luctus ut iaculis nulla per cras et? Primis vulputate ante porta parturient dapibus elementum dis, aptent augue. Malesuada, montes porttitor molestie. Adipiscing cursus ante aliquam duis non bibendum mi? Ultrices felis taciti dolor nascetur sed tincidunt, nibh lectus pulvinar. Ultrices facilisis iaculis felis ridiculus consequat vel ad sem risus. Conubia velit cubilia enim convallis etiam! Nulla enim, luctus pellentesque amet scelerisque phasellus.",
                        "privateText": "private text"
                    }
                ],
                "booksurvey": {
                    "travelerType": 4,
                    "pet": false,
                    "travelReason": [1,2,3],
                    "npsMyDashboard": 10,
                    "feedbackMyDashboard": "",
                    "npsProperty": 8,
                    "feedbackProperty": "",
                    "ratings": {
                        "1": {
                            "score": 3,
                            "feedback": "sdasd"
                        },
                        "3": {
                            "score": 4
                        },
                        "4": {
                            "score": 4,
                            "feedback": "Lo que sea"
                        },
                        "5": {
                            "score": 5
                        },
                        "6": {
                            "score": 4,
                            "feedback": "Malas vistas"
                        },
                        "2": {
                            "score": 5
                        }
                    }
                },
                "createdAt": "2022-11-02 09:21:08",
                "updatedAt": "2022-11-02 10:21:08"
            }',
            true
        );

        $addbookservice = new Addbookservice($this->bookRepository);

        $addBookRequest = AddBookRequest::createFromArray($params);
        $addBookResponse = $addbookservice->execute($addBookRequest);

        $this->assertInstanceOf(book::class, $addBookResponse);
        $this->assertInstanceOf(booksurvey::class, $addBookResponse->getbooksurvey());
        $this->assertInstanceOf(ArrayCollection::class, $addBookResponse->getBookTexts());
        $this->assertInstanceOf(BookText::class, $addBookResponse->getBookTexts()[0]);
        $this->assertInstanceOf(ArrayCollection::class, $addBookResponse->getBookTextReply());
        $this->assertInstanceOf(BookTextReply::class, $addBookResponse->getBookTextReply()[0]);
        $this->assertSame(12345, $addBookResponse->getLegacyBookingId());
        $this->assertSame(1681, $addBookResponse->getLegacyPropertyId());
        $this->assertSame(true, $addBookResponse->getStatus());
        $this->assertSame("es", $addBookResponse->getOriginalLanguage()->value());
        $this->assertSame("es", $addBookResponse->getOriginalReplyLanguage()->value());
        $this->assertSame(true, $addBookResponse->getStatusReply());
        $this->assertSame(false, $addBookResponse->isFake());
        $this->assertSame(false, $addBookResponse->isExternal());
        $this->assertSame(false, $addBookResponse->isPending());
        $this->assertSame(false, $addBookResponse->isHidden());
        $this->assertSame("Paco", $addBookResponse->getCustomerName());
        $this->assertSame("Málaga", $addBookResponse->getCustomerCity());
        $this->assertSame("ES", $addBookResponse->getCustomerCountry());
        $this->assertSame("es", $addBookResponse->getCustomerLanguage()->value());
        $this->assertSame("2022-11-02 09:21:08", $addBookResponse->getCreatedAt()->format("Y-m-d H:i:s"));
        $this->assertSame("2022-11-02 10:21:08", $addBookResponse->getUpdatedAt()->format("Y-m-d H:i:s"));

        $this->assertInstanceOf(booksurvey::class, $addBookResponse->getbooksurvey());
        $books = $addBookResponse->getbooksurvey()->getRatings()->__toArray();
        $this->assertSame(6, count($books));
    }

    public function testValidAddBookWithNull(): void
    {
        $params = json_decode('{
            "legacyBookingId": 12345,
            "legacyPropertyId": 1681,
            "status": true,
    
            "createdAt": "2022-11-02 09:21:08",
            "updatedAt": "2022-11-02 10:21:08"

        }', true);

        $addbookservice = new Addbookservice($this->bookRepository);

        $addBookRequest = AddBookRequest::createFromArray($params);
        $addBookResponse = $addbookservice->execute($addBookRequest);

        $this->assertInstanceOf(book::class, $addBookResponse);
        $this->assertSame(1212, $addBookResponse->getUserId());
        $this->assertSame(null, $addBookResponse->getCustomerName());
    }

    public function testValidAddBookNullInBooleanFields(): void
    {
        $params = json_decode('{
            "userId": 7078,
            "status": null,
            "originalLanguage": "fr",
            "statusReply":null,
            "isFake": null,
            "isExternal": null,
            "isUrgent":null,
            "isPending": null,
            "isHidden": null,
            "customerName": "Ricardo",
            "customerCity": "Málaga",
            "customerCountry": "España",
            "customerLanguage": "es",
            "bookTexts":[
                {
                    "text": "Texto",
                    "privateText": "Private text",
                    "language": "de"
                }
            ],
            "bookTextReply": [
                {
                    "language": "es",
                    "text": "text reply"
                }
            ],
            "booksurvey":{
                "travelerType": 1,
                "pet": null,
                "travelReason": [3, 5],
                "npsMyDashboard": 5,
                "feedbackMyDashboard": "Feedback MyDashboard",
                "npsProperty": 5,
                "feedbackProperty": "Feedback Property",
                "ratings": {
                    "1": {
                        "score": 3,
                        "feedback": "sdasd"
                    },
                    "3": {
                        "score": 4
                    },
                    "4": {
                        "score": 2,
                        "feedback": "Lo que sea"
                    },
                    "5": {
                        "score": 3
                    },
                    "6": {
                        "score": 4,
                        "feedback": "Malas vistas"
                    },
                    "2": {
                        "score": 5
                    }
                },
                "overallRating": 9
            }
        }', true);

        $addbookservice = new Addbookservice($this->bookRepository);

        $addBookRequest = AddBookRequest::createFromArray($params);
        $addBookResponse = $addbookservice->execute($addBookRequest);

        $this->assertSame(false, $addBookResponse->getStatus());
        $this->assertSame(false, $addBookResponse->getStatusReply());
        $this->assertSame(false, $addBookResponse->isFake());
        $this->assertSame(false, $addBookResponse->isExternal());
        $this->assertSame(false, $addBookResponse->isUrgent());
        $this->assertSame(false, $addBookResponse->isPending());
        $this->assertSame(false, $addBookResponse->isHidden());
        $this->assertSame(false, $addBookResponse->getbooksurvey()->getPet());
    }

    public function testNotAllowDuplicateBookByLegacyBookId(): void
    {
        $this->expectException(DuplicatedBookByLegacyBookIdException::class);

        $paramsBookA = json_decode(
            '{
                "legacyBookId": 12345,
                "legacyBookingId": 9999,
                "legacyPropertyId": 1681,
                "status": true,
                "userId": 123,
                "originalLanguage": "es",
                "originalReplyLanguage": null,
                "statusReply": false,
                "isFake": false,
                "isExternal": false,
                "isPending": false,
                "isHidden": false,
                "customerName": "Paco",
                "customerCity": "Málaga",
                "customerCountry": "ES",
                "customerLanguage": "es",
                "bookTexts": [
                    {
                        "language": "es",
                        "text": "Muchas gracias por su valoración. Ha sido un placer."
                    }
                ],
                "booksurvey": {
                    "travelerType": 4,
                    "pet": false,
                    "travelReason": [1,2,3],
                    "npsMyDashboard": 10,
                    "feedbackMyDashboard": "",
                    "npsProperty": 8,
                    "feedbackProperty": "",
                    "ratings": {
                        "1": {
                            "score": 3,
                            "feedback": "sdasd"
                        },
                        "3": {
                            "score": 4
                        },
                        "4": {
                            "score": 4,
                            "feedback": "Lo que sea"
                        },
                        "5": {
                            "score": 5
                        },
                        "6": {
                            "score": 4,
                            "feedback": "Malas vistas"
                        },
                        "2": {
                            "score": 5
                        }
                    }
                },
                "createdAt": "2022-11-02 09:21:08",
                "updatedAt": "2022-11-02 10:21:08"
            }',
            true
        );

        $addbookservice = new Addbookservice($this->bookRepository);
        $addBookRequest = AddBookRequest::createFromArray($paramsBookA);
        $addBookResponse = $addbookservice->execute($addBookRequest);

        $paramsBookB = json_decode(
            '{
                "legacyBookId": 12345,
                "legacyBookingId": 9999,
                "legacyPropertyId": 1681,
                "status": true,
                "userId": 456,
                "originalLanguage": "es",
                "originalReplyLanguage": null,
                "statusReply": false,
                "isFake": false,
                "isExternal": false,
                "isPending": false,
                "isHidden": false,
                "customerName": "Paco",
                "customerCity": "Málaga",
                "customerCountry": "ES",
                "customerLanguage": "es",
                "bookTexts": [
                    {
                        "language": "es",
                        "text": "Muchas gracias por su valoración. Ha sido un placer."
                    }
                ],
                "booksurvey": {
                    "travelerType": 4,
                    "pet": false,
                    "travelReason": [1,2,3],
                    "npsMyDashboard": 10,
                    "feedbackMyDashboard": "",
                    "npsProperty": 8,
                    "feedbackProperty": "",
                    "ratings": {
                        "1": {
                            "score": 3,
                            "feedback": "sdasd"
                        },
                        "3": {
                            "score": 4
                        },
                        "4": {
                            "score": 4,
                            "feedback": "Lo que sea"
                        },
                        "5": {
                            "score": 5
                        },
                        "6": {
                            "score": 4,
                            "feedback": "Malas vistas"
                        },
                        "2": {
                            "score": 5
                        }
                    }
                },
                "createdAt": "2022-11-02 09:21:08",
                "updatedAt": "2022-11-02 10:21:08"
            }',
            true
        );

        $addbookservice = new Addbookservice($this->bookRepository);
        $addBookRequest = AddBookRequest::createFromArray($paramsBookB);
        $addBookResponse = $addbookservice->execute($addBookRequest);
    }
}
