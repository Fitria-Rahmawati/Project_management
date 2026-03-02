<?php

namespace App\Controllers;
use App\Models\IssueLogModel;

class IssueLogs extends BaseController
{
    public function index($issueId)
    {
        return view('issue_logs/index', [
            'logs' => (new IssueLogModel())
                ->where('issue_id',$issueId)
                ->findAll()
        ]);
    }
}