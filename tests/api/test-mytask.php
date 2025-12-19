<?php

class PM_My_Task_API_Test extends PM_API_Test_Case {
    
    public function test_get_user_activities() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users/' . $this->admin_user . '/user-activities');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_user_tasks_by_type() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users/' . $this->admin_user . '/tasks');
        $request->set_query_params([
            'type' => 'outstanding'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_user_calendar_tasks() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users/' . $this->admin_user . '/tasks/calender');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_assigned_users() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/assigned_users');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }

    public function test_get_user_activities_unauthorized() {
        wp_set_current_user(0);
        
        $request = new WP_REST_Request('GET', '/pm/v2/users/' . $this->admin_user . '/user-activities');
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(401, $response->get_status());
    }
}
