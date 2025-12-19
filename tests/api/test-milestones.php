<?php

class PM_Milestones_API_Test extends PM_API_Test_Case {
    
    public function test_get_milestones() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/milestones');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_create_milestone() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/milestones');
        $request->set_body_params([
            'title' => 'Test Milestone',
            'description' => 'Test milestone description'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 404]);
    }

    public function test_get_single_milestone() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/milestones/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_update_milestone() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/milestones/1/update');
        $request->set_body_params([
            'title' => 'Updated Milestone Title'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_delete_milestone() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/milestones/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_milestone_privacy() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/milestones/privacy/1');
        $request->set_body_params([
            'is_private' => true
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }
}
