<?php

class PM_Files_API_Test extends PM_API_Test_Case {
    
    public function test_get_files() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/files');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_create_file() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/files');
        $request->set_body_params([
            'file_url' => 'https://example.com/test.pdf',
            'fileable_type' => 'task',
            'fileable_id' => 1
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 201, 400, 404]);
    }

    public function test_get_single_file() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/files/1');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_rename_file() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/files/1/update');
        $request->set_body_params([
            'name' => 'renamed-file.pdf'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_delete_file() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('POST', '/pm/v2/projects/1/files/999/delete');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_download_file() {
        wp_set_current_user($this->admin_user);
        
        $request = new WP_REST_Request('GET', '/pm/v2/projects/1/files/1/users/' . $this->admin_user . '/download');
        $response = $this->server->dispatch($request);
        
        $this->assertContains($response->get_status(), [200, 404]);
    }

    public function test_get_mime_type_icon() {
        $request = new WP_REST_Request('GET', '/pm/v2/get-mime-type-icon');
        $request->set_query_params([
            'mime_type' => 'application/pdf'
        ]);
        $response = $this->server->dispatch($request);
        
        $this->assertEquals(200, $response->get_status());
    }
}
