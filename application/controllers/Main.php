<?php
class Main extends CI_Controller
{
    function index()
    {
        $this->load->view('crud/index');
    }
    function store()
    {
        $html = $this->mainmodel->store();
        echo json_encode($html);
    }

    public function history()
{
    $historyData = $this->mainmodel->getHistory();

    $groupedbyDate = [];
    foreach ($historyData as $item) {
        $date = $item['created_date'];

        if (!isset($groupedbyDate[$date])) {
            $groupedbyDate[$date] = [];
        }

        $groupedbyDate[$date][] = $item;
    }
    $response = array(
        'html' => $this->load->view('crud/history', array('groupedbyDate' => $groupedbyDate), true)
    );

    $this->output->set_content_type('application/json')->set_output(json_encode($response));
}

}

?>