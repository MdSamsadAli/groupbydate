<?php
class MainModel extends CI_Model
{
    public function store()
    {
        // Get the JSON data from the request
        $json_data = $this->input->raw_input_stream;
        
        // Decode the JSON data into an array
        $data = json_decode($json_data, true);
        // var_dump($data);

        // Validate and insert data into the database
        if (!empty($data)) {
            $insert_data = array();

            foreach ($data as $row) {
                $product = isset($row['product']) ? $row['product'] : '';
                $price = isset($row['price']) ? $row['price'] : '';

                if (!empty($product) && !empty($price)) {
                    // Create an array for each row of data
                    $insert_data[] = array(
                        'product' => $product,
                        'price' => $price,
                        'created_date' => date('Y-m-d'),
                    );
                }
            }

            if (!empty($insert_data)) {
                // Insert data into the 'products' table using CodeIgniter's batch insert
                $this->db->insert_batch('products', $insert_data);

                // Respond with a success message
                $response = array('status' => 'success', 'message' => 'Data inserted successfully');
            } else {
                $response = array('status' => 'error', 'message' => 'No valid data to insert.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'No data received.');
        }

        // Send JSON response back to the client
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    function getHistory()
    {
        $sql = 'SELECT *, 
        created_date
        FROM products'; 
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return array();
        }

    }

    
}

?>