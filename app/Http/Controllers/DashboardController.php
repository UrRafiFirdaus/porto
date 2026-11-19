<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects_total' => Project::count(),
            'projects_published' => Project::where('is_published', true)->count(),
            'skills_total' => Skill::count(),
            'experiences_total' => Experience::count(),
            'educations_total' => Education::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $profile = PortfolioProfile::first();
        $recentProjects = Project::latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'profile', 'recentProjects', 'recentMessages'));
    }
}
