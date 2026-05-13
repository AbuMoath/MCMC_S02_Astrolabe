<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Module3\PublicUsers;
use App\Models\Module3\Administrator;
use App\Models\Module3\Agency;
use App\Models\Module3\Inquiry;

class Module3SystemValidationTest extends TestCase
{
    /**
     * Test that all Module3 models can be instantiated.
     */
    public function test_module3_models_can_be_instantiated()
    {
        // Test PublicUsers model
        $publicUser = new PublicUsers();
        $this->assertInstanceOf(PublicUsers::class, $publicUser);
        
        // Test Administrator model
        $admin = new Administrator();
        $this->assertInstanceOf(Administrator::class, $admin);
        
        // Test Agency model
        $agency = new Agency();
        $this->assertInstanceOf(Agency::class, $agency);
        
        // Test Inquiry model
        $inquiry = new Inquiry();
        $this->assertInstanceOf(Inquiry::class, $inquiry);
    }

    /**
     * Test that Module3 model search methods work.
     */
    public function test_module3_model_search_methods()
    {
        // Test PublicUsers search
        $result = PublicUsers::search('test');
        $this->assertNotNull($result);
        
        // Test Administrator search
        $result = Administrator::search('test');
        $this->assertNotNull($result);
        
        // Test Agency search
        $result = Agency::search('test');
        $this->assertNotNull($result);
        
        // Test Inquiry search
        $result = Inquiry::search('test');
        $this->assertNotNull($result);
    }

    /**
     * Test that Module3 controllers can be instantiated.
     */
    public function test_module3_controllers_can_be_instantiated()
    {
        $userController = new \App\Http\Controllers\Module3\PublicUser\UserController();
        $this->assertInstanceOf(\App\Http\Controllers\Module3\PublicUser\UserController::class, $userController);
        
        $inquiryController = new \App\Http\Controllers\Module3\PublicUser\InquiryController();
        $this->assertInstanceOf(\App\Http\Controllers\Module3\PublicUser\InquiryController::class, $inquiryController);
        
        $adminController = new \App\Http\Controllers\Module3\Admin\AdminController();
        $this->assertInstanceOf(\App\Http\Controllers\Module3\Admin\AdminController::class, $adminController);
        
        $agencyController = new \App\Http\Controllers\Module3\Agency\AgencyController();
        $this->assertInstanceOf(\App\Http\Controllers\Module3\Agency\AgencyController::class, $agencyController);
        
        $reviewController = new \App\Http\Controllers\Module3\Agency\AgencyReviewAndNotificationController();
        $this->assertInstanceOf(\App\Http\Controllers\Module3\Agency\AgencyReviewAndNotificationController::class, $reviewController);
    }

    /**
     * Test basic routes are accessible.
     */
    public function test_basic_routes_are_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $response = $this->get('/login');
        $response->assertStatus(200);
        
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /**
     * Test that Module3 file structure is correct.
     */
    public function test_module3_file_structure_exists()
    {
        $requiredFiles = [
            'app/Models/Module3/PublicUsers.php',
            'app/Models/Module3/Administrator.php',
            'app/Models/Module3/Agency.php',
            'app/Models/Module3/Inquiry.php',
            'app/Models/Module3/BaseModel.php',
            'app/Models/Module3/Traits/ModelTraits.php',
            'app/Http/Controllers/Module3/PublicUser/UserController.php',
            'app/Http/Controllers/Module3/PublicUser/InquiryController.php',
            'app/Http/Controllers/Module3/Admin/AdminController.php',
            'app/Http/Controllers/Module3/Agency/AgencyController.php',
            'app/Http/Controllers/Module3/Agency/AgencyReviewAndNotificationController.php',
        ];

        foreach ($requiredFiles as $file) {
            $this->assertFileExists(base_path($file), "Required file {$file} does not exist");
        }
    }
}
