<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\City;
use App\Models\HeroContent;
use App\Models\Testimonial;
use App\Models\Resource;
use Illuminate\Support\Facades\DB;

class ContentManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Category::truncate();
        City::truncate();
        HeroContent::truncate();
        Testimonial::truncate();
        Resource::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->createCategories();
        $this->createCities();
        $this->createHeroContent();
        $this->createTestimonials();
        $this->createResources();

        $this->command->info('Content management data seeded successfully!');
    }

    private function createCategories()
    {
        $categories = [
            // Main Categories
            [
                'name' => 'Early Learning & Care',
                'slug' => 'early-learning-care',
                'subtitle' => 'Confident Choices for Early Care',
                'description' => 'Locate top-rated, trustworthy providers to support your child\'s development.',
                'providers_count' => 120,
                'icon' => 'fa-solid fa-child',
                'tags' => ['Daycare', 'Child-care', 'Preschool'],
                'image_url' => 'https://images.unsplash.com/photo-1650504148053-ae51b12dc1d4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080',
                'sort_order' => 1,
                'status' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Schools & Education',
                'slug' => 'schools-education',
                'subtitle' => 'Invest in a Brighter Tomorrow',
                'description' => 'Choose from verified schools committed to excellence, character-building, and success.',
                'providers_count' => 35,
                'icon' => 'fa-solid fa-school',
                'tags' => ['Private Elementary', 'Private Middle School', 'Private High School'],
                'image_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080',
                'sort_order' => 2,
                'status' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'After-school & Tutoring',
                'slug' => 'after-school-tutoring',
                'subtitle' => 'Support Beyond the School Bell',
                'description' => 'Discover programs and tutoring that help your child thrive academically and creatively.',
                'providers_count' => 45,
                'icon' => 'fa-solid fa-book',
                'tags' => ['Afterschool Programs', 'Tutoring Services', 'Enrichment Activities'],
                'image_url' => 'https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=1169&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'sort_order' => 3,
                'status' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Wellness & Family Support',
                'slug' => 'wellness-family-support',
                'subtitle' => 'Strength for Every Step of the Journey',
                'description' => 'Explore trusted programs that nurture the well-being of parents, children, and caregivers.',
                'providers_count' => 25,
                'icon' => 'fa-solid fa-heart',
                'tags' => ['Pediatric & Family Wellness', 'Therapy & Counseling', 'Yoga & Pilates', 'Parent Support Services'],
                'image_url' => 'https://images.unsplash.com/photo-1597075958693-75173d1c837f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080',
                'sort_order' => 4,
                'status' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Events & Activities',
                'slug' => 'events-activities',
                'subtitle' => 'Play. Explore. Connect.',
                'description' => 'Find family-friendly events and programs that inspire joy, learning, and togetherness.',
                'providers_count' => 65,
                'icon' => 'fa-solid fa-lightbulb',
                'tags' => ['Birthday & Party Services', 'Camps (Summer, Holiday, Seasonal)', 'Family Events & Entertainment'],
                'image_url' => 'https://images.unsplash.com/photo-1687186511607-68b95444ea33?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080',
                'sort_order' => 5,
                'status' => true,
                'parent_id' => null,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Get main categories for subcategories
        $earlyLearning = Category::where('slug', 'early-learning-care')->first();
        $afterSchool = Category::where('slug', 'after-school-tutoring')->first();
        $wellness = Category::where('slug', 'wellness-family-support')->first();

        $subcategories = [
            [
                'name' => 'Daycare Centers',
                'slug' => 'daycare-centers',
                'subtitle' => 'Safe and Nurturing Environments',
                'description' => 'Find licensed daycare centers that provide safe, nurturing environments for your children.',
                'providers_count' => 85,
                'icon' => 'fa-solid fa-baby',
                'tags' => ['Full Day Care', 'Part Time Care', 'Infant Care', 'Toddler Care'],
                'image_url' => 'https://images.unsplash.com/photo-1541692646447-34b4fcf81757?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'sort_order' => 1,
                'status' => true,
                'parent_id' => $earlyLearning->id,
            ],
            [
                'name' => 'Preschool Programs',
                'slug' => 'preschool-programs',
                'subtitle' => 'Early Education Foundations',
                'description' => 'Quality preschool programs that build strong educational foundations for young learners.',
                'providers_count' => 35,
                'icon' => 'fa-solid fa-graduation-cap',
                'tags' => ['Montessori', 'Play Based', 'Academic Focus', 'Half Day Programs'],
                'image_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'sort_order' => 2,
                'status' => true,
                'parent_id' => $earlyLearning->id,
            ],
            [
                'name' => 'Academic Tutoring',
                'slug' => 'academic-tutoring',
                'subtitle' => 'Boost Academic Performance',
                'description' => 'Professional tutoring services to help students excel in their academic subjects.',
                'providers_count' => 28,
                'icon' => 'fa-solid fa-calculator',
                'tags' => ['Math Tutoring', 'Science Help', 'Reading Support', 'Test Preparation'],
                'image_url' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'sort_order' => 1,
                'status' => true,
                'parent_id' => $afterSchool->id,
            ],
            [
                'name' => 'Sports & Recreation',
                'slug' => 'sports-recreation',
                'subtitle' => 'Active and Healthy Lifestyles',
                'description' => 'Sports programs and recreational activities to keep children active and healthy.',
                'providers_count' => 17,
                'icon' => 'fa-solid fa-baseball',
                'tags' => ['Soccer', 'Basketball', 'Swimming', 'Gymnastics', 'Martial Arts'],
                'image_url' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'sort_order' => 2,
                'status' => true,
                'parent_id' => $afterSchool->id,
            ],
            [
                'name' => 'Mental Health Services',
                'slug' => 'mental-health-services',
                'subtitle' => 'Supporting Emotional Well-being',
                'description' => 'Professional mental health services for children, teens, and families.',
                'providers_count' => 15,
                'icon' => 'fa-solid fa-brain',
                'tags' => ['Child Therapy', 'Family Counseling', 'Anxiety Support', 'Behavioral Therapy'],
                'image_url' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'sort_order' => 1,
                'status' => true,
                'parent_id' => $wellness->id,
            ],
        ];

        foreach ($subcategories as $subcategory) {
            Category::create($subcategory);
        }
    }

    private function createCities()
    {
        $cities = [
            [
                'name' => 'Dallas',
                'state' => 'TX',
                'providers_count' => 156,
                'families_count' => 2340,
                'icon_url' => 'dummy.png',
                'link' => '/dallas',
                'is_coming_soon' => false,
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Houston',
                'state' => 'TX',
                'providers_count' => 142,
                'families_count' => 2180,
                'icon_url' => 'dummy.png',
                'link' => '/houston',
                'is_coming_soon' => false,
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Austin',
                'state' => 'TX',
                'providers_count' => 98,
                'families_count' => 1670,
                'icon_url' => 'dummy.png',
                'link' => '/austin',
                'is_coming_soon' => false,
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'name' => 'San Antonio',
                'state' => 'TX',
                'providers_count' => 87,
                'families_count' => 1540,
                'icon_url' => 'dummy.png',
                'link' => '/san-antonio',
                'is_coming_soon' => false,
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'name' => 'Fort Worth',
                'state' => 'TX',
                'providers_count' => 76,
                'families_count' => 1320,
                'icon_url' => 'dummy.png',
                'link' => '/fort-worth',
                'is_coming_soon' => false,
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'name' => 'Plano',
                'state' => 'TX',
                'providers_count' => 54,
                'families_count' => 980,
                'icon_url' => 'dummy.png',
                'link' => '/plano',
                'is_coming_soon' => false,
                'sort_order' => 6,
                'status' => true,
            ],
            [
                'name' => 'San Diego',
                'state' => 'CA',
                'providers_count' => 0,
                'families_count' => 0,
                'icon_url' => 'dummy.png',
                'link' => null,
                'is_coming_soon' => true,
                'sort_order' => 7,
                'status' => true,
            ],
            [
                'name' => 'Phoenix',
                'state' => 'AZ',
                'providers_count' => 0,
                'families_count' => 0,
                'icon_url' => 'dummy.png',
                'link' => null,
                'is_coming_soon' => true,
                'sort_order' => 8,
                'status' => true,
            ],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }

    private function createHeroContent()
    {
        HeroContent::create([
            'title_part1' => 'Your Family\'s',
            'title_part2' => 'trusted guide to care, learning, activities & wellness services – all in one hub.',
            'description' => 'Find and compare family services near you! Discover amazing daycare centers, fun activities, and wellness services that kids and parents love!',
            'providers_count' => 400,
            'rating' => 4.9,
            'support_text' => '24/7 Support',
            'status' => true,
        ]);
    }

    private function createTestimonials()
    {
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'location' => 'Dallas, TX',
                'rating' => 5,
                'content' => 'Found the perfect daycare for our toddler through this platform. The comparison feature saved us so much time and stress!',
                'avatar_url' => 'dummy.png',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Michael Chen',
                'location' => 'Houston, TX',
                'rating' => 5,
                'content' => 'As a busy parent, this website has been a lifesaver. We discovered amazing after-school programs we never knew existed in our area.',
                'avatar_url' => 'dummy.png',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Emily Rodriguez',
                'location' => 'Austin, TX',
                'rating' => 5,
                'content' => 'The detailed provider profiles and real parent reviews helped us make the best choice for our family. Highly recommended!',
                'avatar_url' => 'dummy.png',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'name' => 'David Thompson',
                'location' => 'San Antonio, TX',
                'rating' => 5,
                'content' => 'Finally, a comprehensive platform that brings all family services together. The booking process was seamless and easy.',
                'avatar_url' => 'dummy.png',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'name' => 'Lisa Martinez',
                'location' => 'Fort Worth, TX',
                'rating' => 5,
                'content' => 'The wellness services section helped us find a fantastic pediatric therapist for our child. Thank you for this amazing resource!',
                'avatar_url' => 'dummy.png',
                'sort_order' => 5,
                'status' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }

    private function createResources()
    {
        $resources = [
            [
                'title' => 'How to Choose the Right Daycare for Your Child',
                'description' => 'A comprehensive guide to help parents make informed decisions when selecting childcare.',
                'category' => 'Parenting Guide',
                'image_url' => 'https://media.istockphoto.com/id/517188688/photo/mountain-landscape.jpg?s=612x612&w=0&k=20&c=A63koPKaCyIwQWOTFBRWXj_PwCrR4cEoOw2S9Q7yVl8=',
                'content' => $this->generateContent('daycare'),
                'read_time' => '8 min read',
                'slug' => 'how-to-choose-right-daycare',
                'meta_title' => 'How to Choose the Right Daycare - Complete Guide',
                'meta_description' => 'Learn how to select the perfect daycare for your child with our comprehensive guide covering safety, curriculum, and more.',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'The Benefits of After-School Programs for Children',
                'description' => 'Discover how after-school activities can enhance your child\'s development and academic performance.',
                'category' => 'Child Development',
                'image_url' => 'https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=1169&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'content' => $this->generateContent('after-school'),
                'read_time' => '6 min read',
                'slug' => 'benefits-after-school-programs',
                'meta_title' => 'Benefits of After-School Programs for Children',
                'meta_description' => 'Explore the numerous benefits that after-school programs offer for children\'s social, emotional, and academic development.',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Understanding Early Childhood Education Options',
                'description' => 'A detailed overview of different preschool and early learning approaches available to parents.',
                'category' => 'Education',
                'image_url' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'content' => $this->generateContent('early-education'),
                'read_time' => '10 min read',
                'slug' => 'early-childhood-education-options',
                'meta_title' => 'Early Childhood Education Options Explained',
                'meta_description' => 'Compare different early childhood education approaches including Montessori, Reggio Emilia, and play-based learning.',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'title' => 'Finding Quality Tutoring Services for Your Child',
                'description' => 'Learn what to look for when selecting tutoring services and how to ensure the best fit for your child.',
                'category' => 'Education',
                'image_url' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'content' => $this->generateContent('tutoring'),
                'read_time' => '7 min read',
                'slug' => 'finding-quality-tutoring-services',
                'meta_title' => 'How to Find Quality Tutoring Services',
                'meta_description' => 'Essential tips for selecting the right tutoring services that match your child\'s learning needs and personality.',
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'title' => 'The Importance of Family Wellness Services',
                'description' => 'Exploring how wellness services can support the entire family\'s mental and physical health.',
                'category' => 'Wellness',
                'image_url' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&w=1080&q=80',
                'content' => $this->generateContent('wellness'),
                'read_time' => '5 min read',
                'slug' => 'importance-family-wellness-services',
                'meta_title' => 'Family Wellness Services - Why They Matter',
                'meta_description' => 'Discover how family wellness services can improve your family\'s overall health and well-being.',
                'sort_order' => 5,
                'status' => true,
            ],
        ];

        foreach ($resources as $resource) {
            Resource::create($resource);
        }
    }

    private function generateContent($type)
    {
        $contents = [
            'daycare' => "<h2>Choosing the Right Daycare: A Parent's Guide</h2>
                        <p>Selecting a daycare is one of the most important decisions parents make. This comprehensive guide will help you navigate the process with confidence.</p>
                        
                        <h3>Key Factors to Consider</h3>
                        <ul>
                            <li><strong>Safety and Security:</strong> Look for proper licensing, secure facilities, and emergency procedures</li>
                            <li><strong>Staff Qualifications:</strong> Check caregiver credentials, experience, and staff-to-child ratios</li>
                            <li><strong>Curriculum and Activities:</strong> Ensure age-appropriate learning and development activities</li>
                            <li><strong>Location and Hours:</strong> Consider proximity to home/work and operating hours</li>
                            <li><strong>Parent Communication:</strong> Look for regular updates and open communication channels</li>
                        </ul>
                        
                        <h3>Questions to Ask During Tours</h3>
                        <p>Prepare these essential questions when visiting potential daycares:</p>
                        <ul>
                            <li>What is your staff turnover rate?</li>
                            <li>How do you handle discipline and behavior management?</li>
                            <li>What is your sick child policy?</li>
                            <li>Can you provide references from current parents?</li>
                            <li>How do you accommodate different learning styles?</li>
                        </ul>",
            
            'after-school' => "<h2>The Transformative Power of After-School Programs</h2>
                            <p>After-school programs offer more than just supervision—they provide valuable opportunities for growth and development.</p>
                            
                            <h3>Academic Benefits</h3>
                            <p>Structured after-school programs can significantly improve academic performance through:</p>
                            <ul>
                                <li>Homework assistance and tutoring</li>
                                <li>Reinforcement of classroom learning</li>
                                <li>Development of study skills and habits</li>
                                <li>Exposure to new learning methods</li>
                            </ul>
                            
                            <h3>Social and Emotional Development</h3>
                            <p>Children benefit from social interactions and emotional support in after-school settings:</p>
                            <ul>
                                <li>Building friendships and social skills</li>
                                <li>Developing teamwork and cooperation</li>
                                <li>Building confidence and self-esteem</li>
                                <li>Learning conflict resolution</li>
                            </ul>",
            
            'early-education' => "<h2>Navigating Early Childhood Education Options</h2>
                                <p>Understanding different educational approaches can help you choose the best fit for your child's learning style.</p>
                                
                                <h3>Popular Educational Approaches</h3>
                                <ul>
                                    <li><strong>Montessori:</strong> Child-directed learning in prepared environments</li>
                                    <li><strong>Reggio Emilia:</strong> Project-based learning inspired by child interests</li>
                                    <li><strong>Play-Based:</strong> Learning through structured and unstructured play</li>
                                    <li><strong>Academic-Focused:</strong> Structured curriculum with specific learning goals</li>
                                </ul>
                                
                                <h3>What to Look For</h3>
                                <p>When evaluating early education programs, consider:</p>
                                <ul>
                                    <li>Teacher qualifications and experience</li>
                                    <li>Classroom environment and materials</li>
                                    <li>Balance of structured and free play</li>
                                    <li>Communication with parents</li>
                                    <li>Philosophy alignment with family values</li>
                                </ul>",
            
            'tutoring' => "<h2>Finding the Perfect Tutoring Match</h2>
                        <p>The right tutoring service can make a significant difference in your child's academic journey.</p>
                        
                        <h3>Types of Tutoring Services</h3>
                        <ul>
                            <li><strong>One-on-One Tutoring:</strong> Personalized attention for specific needs</li>
                            <li><strong>Small Group Sessions:</strong> Collaborative learning environment</li>
                            <li><strong>Online Tutoring:</strong> Flexible scheduling and access to specialists</li>
                            <li><strong>Subject-Specific Help:</strong> Focused support in particular areas</li>
                        </ul>
                        
                        <h3>Evaluation Criteria</h3>
                        <p>Consider these factors when selecting tutoring services:</p>
                        <ul>
                            <li>Tutor qualifications and background checks</li>
                            <li>Teaching methodology and approach</li>
                            <li>Progress tracking and reporting</li>
                            <li>Flexibility and scheduling options</li>
                            <li>Cost and value for money</li>
                        </ul>",
            
            'wellness' => "<h2>Family Wellness: A Holistic Approach</h2>
                        <p>Wellness services support the entire family's physical, mental, and emotional health.</p>
                        
                        <h3>Types of Family Wellness Services</h3>
                        <ul>
                            <li><strong>Mental Health Support:</strong> Counseling and therapy services</li>
                            <li><strong>Physical Wellness:</strong> Fitness and nutrition guidance</li>
                            <li><strong>Parenting Support:</strong> Classes and coaching for parents</li>
                            <li><strong>Child Development:</strong> Specialized services for children's needs</li>
                        </ul>
                        
                        <h3>Benefits for Families</h3>
                        <p>Wellness services offer numerous advantages:</p>
                        <ul>
                            <li>Improved communication and relationships</li>
                            <li>Better stress management</li>
                            <li>Enhanced coping skills</li>
                            <li>Stronger family bonds</li>
                            <li>Overall improved quality of life</li>
                        </ul>"
        ];

        return $contents[$type] ?? "<p>Content coming soon...</p>";
    }
}