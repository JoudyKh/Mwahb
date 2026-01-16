<?php

namespace App\Constants;
use App\Models\Info;
use App\Models\Offer;
use App\Models\Section;
use Illuminate\Validation\Rule;
use App\Http\Resources\OfferResource;
use App\Services\App\User\UserService;
use App\Http\Resources\Section\CourseResource;
use App\Http\Resources\Section\SectionResource;
use App\Services\General\Teacher\TeacherService;

/**
 * @OA\Schema(
 *     schema="UpdateInfoRequest",
 *     type="object",
 *     title="Update Info Request",
 *     description="Request body for updating information",
 *     @OA\Property(property="contact-whatsapp", type="string", description="WhatsApp link", nullable=true),
 *     @OA\Property(property="contact-linkedin", type="string", format="url", description="LinkedIn link", nullable=true),
 *     @OA\Property(property="contact-facebook", type="string", format="url", description="Facebook link", nullable=true),
 *     @OA\Property(property="contact-telegram", type="string", format="url", description="Telegram link", nullable=true),
 *     @OA\Property(property="contact-youtube", type="string", format="url", description="YouTube link", nullable=true),
 *     @OA\Property(property="contact-instagram", type="string", format="url", description="Instagram link", nullable=true),
 *     @OA\Property(property="contact-email", type="string", format="email", description="Contact email", nullable=true),
 *     @OA\Property(property="contact-phone", type="string", description="Contact phone number", nullable=true),
 *     @OA\Property(property="cash-info-ar", type="string", description="Cash info in Arabic", nullable=true),
 *     @OA\Property(property="cash-info-en", type="string", description="Cash info in English", nullable=true),
 *     @OA\Property(property="home-show_teachers_section", type="string", enum={"true", "false"}, description="Show teachers section on home page", nullable=true),
 *     @OA\Property(property="hero-description-ar", type="string", description="Hero description in Arabic", nullable=true),
 *     @OA\Property(property="hero-description-en", type="string", description="Hero description in English", nullable=true),
 *     @OA\Property(property="hero-hours_count", type="string", description="Number of hours", nullable=true),
 *     @OA\Property(property="hero-students_count", type="string", description="Number of students", nullable=true),
 *     @OA\Property(property="hero-courses_count", type="string", description="Number of courses", nullable=true),
 *     @OA\Property(property="hero-video", type="string", format="binary", description="Hero video file (mp4)", nullable=true),
 *     @OA\Property(property="hero-image", type="string", format="binary", description="Hero imge file (png)", nullable=true),
 *     @OA\Property(property="sections-header-ar", type="string", description="Sections header in Arabic", nullable=true),
 *     @OA\Property(property="sections-header-en", type="string", description="Sections header in English", nullable=true),
 *     @OA\Property(property="courses-header-ar", type="string", description="Courses header in Arabic", nullable=true),
 *     @OA\Property(property="courses-header-en", type="string", description="Courses header in English", nullable=true),
 *     @OA\Property(property="overview-description-en", type="string", description="Overview description in English", nullable=true),
 *     @OA\Property(property="overview-description-ar", type="string", description="Overview description in Arabic", nullable=true),
 *     @OA\Property(property="overview-online_degrees-en", type="string", description="Online degrees description in English", nullable=true),
 *     @OA\Property(property="overview-online_degrees-ar", type="string", description="Online degrees description in Arabic", nullable=true),
 *     @OA\Property(property="overview-short_courses-en", type="string", description="Short courses description in English", nullable=true),
 *     @OA\Property(property="overview-short_courses-ar", type="string", description="Short courses description in Arabic", nullable=true),
 *     @OA\Property(property="overview-professional_instructors-en", type="string", description="Professional instructors description in English", nullable=true),
 *     @OA\Property(property="overview-professional_instructors-ar", type="string", description="Professional instructors description in Arabic", nullable=true),
 *     @OA\Property(property="overview-image1", type="string", format="binary", description="Overview image 1 (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="overview-image2", type="string", format="binary", description="Overview image 2 (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="overview-image3", type="string", format="binary", description="Overview image 3 (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="overview-image4", type="string", format="binary", description="Overview image 4 (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="overview-image5", type="string", format="binary", description="Overview image 5 (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="overview-image6", type="string", format="binary", description="Overview image 6 (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="overview-image7", type="string", format="binary", description="Overview image 7 (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="instructors-header-ar", type="string", description="Instructors header in Arabic", nullable=true),
 *     @OA\Property(property="instructors-header-en", type="string", description="Instructors header in English", nullable=true),
 *     @OA\Property(property="application-description-en", type="string", description="Application description in English", nullable=true),
 *     @OA\Property(property="application-description-ar", type="string", description="Application description in Arabic", nullable=true),
 *     @OA\Property(property="application-app_store", type="string", format="url", description="App Store link", nullable=true),
 *     @OA\Property(property="application-google_play", type="string", format="url", description="Google Play link", nullable=true),
 *     @OA\Property(property="application-file", type="string", format="binary", description="Application file", nullable=true),
 *     @OA\Property(property="library-description-ar", type="string", description="Library description in Arabic", nullable=true),
 *     @OA\Property(property="library-description-en", type="string", description="Library description in English", nullable=true),
 *     @OA\Property(property="library-image", type="string", format="binary", description="Library image (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="about_us-image", type="string", format="binary", description="About us image (png, jpg, jpeg)", nullable=true),
 *     @OA\Property(property="about_us-description", type="string", description="About us description", nullable=true),
 * )
 *
 * @OA\Post(
 *     path="/admin/infos/update",
 *     operationId="post-update-info",
 *     tags={"Admin", "Admin - Info"},
 *     security={{ "bearerAuth": {} ,"lmsAuth": {} }},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Site information data",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(ref="#/components/schemas/UpdateInfoRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid.")
 *         )
 *     )
 * )
 */
class MawahbInfo
{
    /**
     * @INFO
     * @var array
     **/
    public static $infos = [
        'cash' => [
            'info' => [

                'ar' =>

                    '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Demo Text</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                padding: 20px;
                            }
                            .demo-text {
                                font-size: 18px;
                                color: #333;
                                border: 1px solid #ddd;
                                padding: 10px;
                                background-color: #f9f9f9;
                            }
                        </style>
                    </head>
                    <body>

                        <div class="demo-text">
                            This is a demo text block used to demonstrate basic HTML formatting. You can modify this text or apply various styles to make it stand out.
                        </div>

                    </body>
                    </html>
                    ',



                'en' =>

                    '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Demo Text</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                padding: 20px;
                            }
                            .demo-text {
                                font-size: 18px;
                                color: #333;
                                border: 1px solid #ddd;
                                padding: 10px;
                                background-color: #f9f9f9;
                            }
                        </style>
                    </head>
                    <body>

                        <div class="demo-text">
                            This is a demo text block used to demonstrate basic HTML formatting. You can modify this text or apply various styles to make it stand out.
                        </div>

                    </body>
                    </html>
                    ',
            ],
        ],

        'home' => [
            'show_teachers_section' => 'true',
        ],

        'library' => [
            'image' => '/SiteFiles/overview.jpeg',
            'description' => [
                'ar' => 'المكتبة هي تجميع لمصادر وخدمات المعلومات, مكتبة مواهب للخدمات الالكترونية والطلابية ، تختص بالمجال الاكاديمي والعلمي لدى الطلبة وتوفر جميع الكتب والملفات والخدمات الجامعية و خدمات المعلمين.',
                'en' => 'The library is a collection of information resources and services. Mawaheb Library for electronic and student services specializes in the academic and scientific field for students and provides all books, files, university services, and teacher services.'
            ],
        ],

        'contact' => [
            'whatsapp' => 'https://www.google.com',
            'linkedin' => 'https://www.google.com',
            'facebook' => 'https://www.google.com',
            'telegram' => 'https://www.google.com',
            'youtube' => 'https://www.google.com',
            'instagram' => 'https://www.google.com',
            'email' => 'jalal@gmail.com',
            'phone' => '0987654321',
        ],

        //new

        'hero' => [
            'description' => [
                'en' => '“Online education is electronically supported learning that relies on the Internet for teacher/student interaction and the distribution of class materials.”',
                'ar' => '"يتم دعم التعليم عبر الإنترنت إلكترونيًا لتعلم ذلك يعتمد على الإنترنت للتفاعل بين المعلم والطالب توزيع المواد الدراسية."',
            ],
            'hours_count' => '60,000+',
            'students_count' => '10,000+',
            'courses_count' => '12+',
            'video' => 'SiteFiles/video1.mp4',
            'image' => 'SiteFiles/image1.png',
        ],
        'sections' => [
            'header' => [
                'en' => 'Discover a new of learning',
                'ar' => 'اكشتف الطرائق الجديدة للتعليم',
            ]
        ],
        'courses' => [
            'header' => [
                'en' => 'Experience a new way of learning through our library of world-class university courses',
                'ar' => 'استمتع بتجربة جديدة للتعلم من خلال مكتبتنا التي تضم دورات عالية المستوى',
            ]
        ],
        'overview' => [

            'description' => [
                'en' => 'It\'s time to excel. This course includes all the essential information that will help you achieve excellence.',
                'ar' => 'حان الوقت لتتفوق. تتضمن هذه الدورة جميع المعلومات الأساسية التي ستساعدك على تحقيق التفوق.',
            ],

            'image1' => 'SiteFiles/image1.jpg',
            'image2' => 'SiteFiles/image2.jpg',
            'image3' => 'SiteFiles/image3.jpg',
            'image4' => 'SiteFiles/image4.jpg',
            'image5' => 'SiteFiles/image5.jpg',
            'image6' => 'SiteFiles/image6.jpg',
            'image7' => 'SiteFiles/image7.jpg',

            'online_degrees' => [
                'en' => 'Get reliable academic degrees from the Internet by taking exams in all scientific specializations, but practice and study well.',
                'ar' => 'احصل على درجات علمية موثوقة من الانترنت عبر اجراء امتحانات في جميع الاختصاصات العلمية و لكن ،تدرب وادرس جيداً',
            ],
            'short_courses' => [
                'en' => 'Get reliable academic degrees from the Internet by taking exams in all scientific specializations, but practice and study well.',
                'ar' => 'احصل على درجات علمية موثوقة من الانترنت عبر اجراء امتحانات في جميع الاختصاصات العلمية و لكن ،تدرب وادرس جيداً',
            ],
            'professional_instructors' => [
                'en' => 'A pool of trainers specialized in the most advanced fields ',
                'ar' => 'خامة من المدربين المختصين في افصل المجالات ',
            ],
        ],
        'instructors' => [
            'header' => [
                'en' => 'Baccalaureate course trainees are students preparing to pass the baccalaureate examinations, an important educational stage that marks the end of secondary education and opens the door to higher education. Baccalaureate courses aim to provide students with the knowledge and skills necessary to achieve success in these examinations. Baccalaureate course trainees are students who prepare to pass the baccalaureate examinations, an important educational stage that marks the end of secondary education and opens the door to higher education. Baccalaureate courses aim to provide students with the knowledge and skills',
                'ar' => 'المتدربون في دورات البكالوريا هم الطلاب الذين يستعدون لاجتياز امتحانات شهادة البكالوريا، وهي مرحلة تعليمية مهمة تشكل نهاية التعليم الثانوي وتفتح الباب أمام التعليم العالي. تهدف دورات البكالوريا إلى تزويد الطلاب بالمعرفة والمهارات اللازمة لتحقيق النجاح في هذه الامتحانات.المتدربون في دورات البكالوريا هم الطلاب الذين يستعدون لاجتياز امتحانات شهادة البكالوريا، وهي مرحلة تعليمية مهمة تشكل نهاية التعليم الثانوي وتفتح الباب أمام التعليم العالي. تهدف دورات البكالوريا إلى تزويد الطلاب بالمعرفة والمهارات اللازمة لتحقيق النجاح في هذه الامتحانات.',
            ]
        ],
        'application' => [
            'description' => [
                'en' => 'Start with us now and download the application',
                'ar' => 'ابدأ معنا الأن وقم بتحميل التطبيق',
            ],
            'app_store' => 'https://www.app.com',
            'google_play' => 'https://www.google.com',

            'file' => 'pdf.pdf',
        ],
        'about_us' => [
            'image' => 'image1.jpg',
            'description' => 'description'
        ],
    ];

    /**
     * @RULES
     * @var array
     **/

    public static $rules = [

        'contact-whatsapp' => ['string'],
        'contact-linkedin' => ['string', 'url'],
        'contact-facebook' => ['string', 'url'],
        'contact-telegram' => ['string', 'url'],
        'contact-youtube' => ['string', 'url'],
        'contact-instagram' => ['string', 'url'],
        'contact-email' => ['string', 'email'],
        'contact-phone' => ['string'],

        'cash-info-ar' => ['string'],
        'cash-info-en' => ['string'],

        'home-show_teachers_section' => ['string', 'in:true,false'],

        'hero-description-ar' => ['string'],
        'hero-description-en' => ['string'],
        'hero-hours_count' => ['string'],
        'hero-students_count' => ['string'],
        'hero-courses_count' => ['string'],

        'hero-video' => ['nullable' ,'file' , 'mimes:mp4'],
        'hero-image' => ['nullable' ,'image' , 'mimes:png,jpg,jpeg'],

        'sections-header-ar' => ['string'],
        'sections-header-en' => ['string'],

        'courses-header-ar' => ['string'],
        'courses-header-en' => ['string'],

        'overview-description-en' => ['string'],
        'overview-description-ar' => ['string'],
        'overview-online_degrees-en' => ['string'],
        'overview-online_degrees-ar' => ['string'],
        'overview-short_courses-en' => ['string'],
        'overview-short_courses-ar' => ['string'],
        'overview-professional_instructors-en' => ['string'],
        'overview-professional_instructors-ar' => ['string'],

        'overview-image1' => ['image', 'mimes:png,jpg,jpeg'],
        'overview-image2' => ['image', 'mimes:png,jpg,jpeg'],
        'overview-image3' => ['image', 'mimes:png,jpg,jpeg'],
        'overview-image4' => ['image', 'mimes:png,jpg,jpeg'],
        'overview-image5' => ['image', 'mimes:png,jpg,jpeg'],
        'overview-image6' => ['image', 'mimes:png,jpg,jpeg'],
        'overview-image7' => ['image', 'mimes:png,jpg,jpeg'],

        'instructors-header-ar' => ['string'],
        'instructors-header-en' => ['string'],

        'application-description-en' => ['string'],
        'application-description-ar' => ['string'],
        'application-app_store' => ['string', 'url'],
        'application-google_play' => ['string', 'url'],
        'application-file' => ['file'],

        'library-description-ar' => ['string'],
        'library-description-en' => ['string'],
        'library-image' => ['image', 'mimes:png,jpg,jpeg'],

        'about_us-image' => ['image', 'mimes:png,jpg,jpeg'],
        'about_us-description' => ['string'],
    ];


    public static function getValidationRules(): array
    {
        return [
            'signup' => [
                'phone_number_country_code' => ['required', 'string', 'min:1', 'max:255'],

                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'username')->whereNull('deleted_at'),
                ],
                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->whereNull('deleted_at'),
                ],

                'full_name' => ['required', 'string', 'min:5', 'max:255'],
                'location' => 'string|max:255',
                'birth_date' => 'string|date_format:Y-m-d',
                'phone_number' => 'required|string|min:8|max:20',
                'password' => 'required|string|min:8',
                'image' => 'image|mimes:png,jpg,jpeg',
                'fcm_token' => 'string',
            ],
        ];
    }

    /**
     * @IMAGE-KEYS
     * @var array
     */
    public static $imageKeys = [
        'hero-image',
        'overview-image1',
        'overview-image2',
        'overview-image3',
        'overview-image4',
        'overview-image5',
        'overview-image6',
        'overview-image7',
        'library-image',
        'about_us-image',
    ];

    /**
     * @VEDIOS-KEYS
     * @var array
     */
    public static $videoKeys = [
        'hero-video',
    ];

    /**
     * @FILE-KEYS
     * @var array
     */
    public static $fileKeys = [
        'application-file',
    ];

    /**
     * @TRANSLATION-KEYS
     * @var array
     */
    public static array $translatableKeys = [
        'cash-info',
        'hero-description',
        'sections-header',
        'courses-header',

        'overview-description',
        'overview-online_degrees',
        'overview-short_courses',
        'overview-professional_instructors',

        'instructors-header',

        'application-description',

        'library-description',
    ];
    /**
     * @COMMA-SEPARATED-KEYS
     * @var array
     */
    public static array $commaSepratadKeys = [];
    public static function home(&$data = [])
    {
        $teacherService = new TeacherService(new UserService());

        $supers = Section::where('type', 'super')->latest()->get();
        $courses = Section::with('teachers')->where('type', Constants::SECTION_TYPE_COURSES)
            ->withSubSectionLessonTimes()->with(['teachers'])
            ->orderByDesc('sections.created_at')->limit(4)->get();

        $canShowTeachers = Info::where('key', 'show_teachers_section')->first();

        $data['instructors']['data'] = $canShowTeachers?->value == 'true' ? $teacherService->getAll(Constants::TEACHER_ROLE, false, false, 4, true)->getData()?->data ?? [] : [];
        $data['sections']['data'] = SectionResource::collection($supers);
        $data['courses']['data'] = CourseResource::collection($courses);

        return $data;
    }

    public static function mobileHome(&$data = [])
    {
        $teacherService = new TeacherService(new UserService());

        $supers = Section::where('type', 'super')->latest()->limit(4)->get();
        $offers = Offer::latest()->limit(5)->get();
        $courses = Section::with(['teachers', 'sectionStudents'])->where('type', Constants::SECTION_TYPE_COURSES)
            ->withSubSectionLessonTimes()->with(['teachers'])
            ->orderByDesc('sections.created_at')->limit(4)->get();

        Section::mergeSubscribed();

        $canShowTeachers = Info::where('key', 'show_teachers_section')->first();

        $data['instructors']['data'] = $canShowTeachers?->value == 'true' ? $teacherService->getAll(Constants::TEACHER_ROLE, false, false, 4, true)->getData()?->data ?? [] : [];
        $data['sections']['data'] = SectionResource::collection($supers);
        $data['offers']['data'] = OfferResource::collection($offers);
        $data['courses']['data'] = CourseResource::collection($courses);

        return $data;
    }
}
