<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\PortfolioProfile;
use App\Models\Project;
use App\Models\Skill;

class HomeController extends Controller
{
    public function index()
    {
        $profile = PortfolioProfile::first();
        $skills = Skill::orderBy('sort_order')->orderBy('id')->get();
        $skillsByCategory = $skills->groupBy('category');
        $experiences = Experience::orderByDesc('is_current')->orderBy('sort_order')->orderByDesc('id')->get();
        $educations = Education::orderByDesc('is_current')->orderBy('sort_order')->orderByDesc('id')->get();
        $projects = Project::where('is_published', true)->orderByDesc('is_featured')->orderBy('sort_order')->orderByDesc('id')->get();

        return view('welcome', compact(
            'profile',
            'skills',
            'skillsByCategory',
            'experiences',
            'educations',
            'projects'
        ));
    }

    public function downloadCv()
    {
        $profile = PortfolioProfile::first();
        if (!$profile || !$profile->cv_path || !file_exists(public_path($profile->cv_path))) {
            return back()->with('error', 'File CV belum tersedia saat ini.');
        }

        $filename = 'CV_' . str_replace(' ', '_', $profile->full_name) . '.pdf';
        return response()->download(public_path($profile->cv_path), $filename);
    }
}
