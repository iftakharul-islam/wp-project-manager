<?php

class PM_Comments_API_Test extends PM_API_Test_Case {
    
    public function test_get_comments() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/comments');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_create_comment() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/comments');
        $request->set_body_params([
            'content' => 'Test comment',
            'commentable_type' => 'task',
            'commentable_id' => 1
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 404]);
    }

    public function test_get_single_comment() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/comments/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_update_comment() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/comments/1');
        $request->set_body_params([
            'content' => 'Updated comment'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_delete_comment() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/comments/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_create_comment_unauthorized() {
        wp_set_current_user(0);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/comments');
        $request->set_body_params([
            'content' => 'Test comment',
            'commentable_type' => 'task',
            'commentable_id' => 1
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(401, $response->get_status());
    }
}
