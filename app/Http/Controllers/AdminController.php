<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kid;


class AdminController extends Controller
{

// Add these methods to your existing AdminController

public function kids(Request $request)
{
    $query = Kid::with([
        'latestCompletedAttempt',
        'inProgressTestAttempt'
    ])->withCount('completedTestAttempts');

    // Search filter
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('kid_name', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%");
        });
    }

    // Status filter
    if ($request->filled('status')) {
        match ($request->status) {
            'completed'   => $query->has('completedTestAttempts'),
            'in_progress' => $query->whereHas('inProgressTestAttempt'),
            'not_taken'   => $query->doesntHave('testAttempts'),
            default       => null,
        };
    }

    // Zone filter
    if ($request->filled('zone')) {
        $query->where('zone', $request->zone);
    }

    // Level filter
    if ($request->filled('level')) {
        $query->whereHas('latestCompletedAttempt', function($q) use ($request) {
            $q->where('level', $request->level);
        });
    }

    // City filter
    if ($request->filled('city')) {
        $query->where('city', 'like', "%{$request->city}%");
    }

    // Country filter
    if ($request->filled('country')) {
        $query->where('country', 'like', "%{$request->country}%");
    }

    // Age range filter
    if ($request->filled('min_age')) {
        $query->where('age', '>=', $request->min_age);
    }
    if ($request->filled('max_age')) {
        $query->where('age', '<=', $request->max_age);
    }

    // Score range filter
    if ($request->filled('min_score') || $request->filled('max_score')) {
        $query->whereHas('latestCompletedAttempt', function($q) use ($request) {
            if ($request->filled('min_score')) {
                $q->where('score', '>=', $request->min_score);
            }
            if ($request->filled('max_score')) {
                $q->where('score', '<=', $request->max_score);
            }
        });
    }

    // Sorting
    $sortField = $request->get('sort', 'created_at');
    $sortOrder = $request->get('order', 'desc');
    
    if ($sortField === 'score' || $sortField === 'level') {
        $query->join('test_attempts', function($join) {
            $join->on('kids.id', '=', 'test_attempts.kid_id')
                 ->where('test_attempts.status', 'completed');
        })
        ->orderBy("test_attempts.{$sortField}", $sortOrder)
        ->select('kids.*');
    } else {
        $query->orderBy($sortField, $sortOrder);
    }

    $kids = $query->paginate(10)->withQueryString();

    return view('admin.kids', compact('kids'));
}

// Export Kids to PDF
public function kidsPdf(Request $request)
{
    $query = Kid::with('latestCompletedAttempt')
        ->withCount('completedTestAttempts');

    // Apply same filters as the main page
    if ($request->filled('status')) {
        match ($request->status) {
            'completed' => $query->has('completedTestAttempts'),
            'not_taken' => $query->doesntHave('testAttempts'),
            default     => null
        };
    }

    if ($request->filled('zone')) {
        $query->where('zone', $request->zone);
    }

    if ($request->filled('level')) {
        $query->whereHas('latestCompletedAttempt', function($q) use ($request) {
            $q->where('level', $request->level);
        });
    }

    $kids = $query->orderByDesc('completed_test_attempts_count')->get();

    $pdf = Pdf::loadView('admin.kids-pdf', compact('kids'))
        ->setPaper('a4', 'landscape');

    return $pdf->stream('kids-' . now()->format('Y-m-d') . '.pdf');
}

// Export Kids to CSV
public function kidsExport(Request $request)
{
    $query = Kid::with('latestCompletedAttempt');

    // Apply filters
    if ($request->filled('status')) {
        match ($request->status) {
            'completed' => $query->has('completedTestAttempts'),
            'not_taken' => $query->doesntHave('testAttempts'),
            default     => null
        };
    }

    if ($request->filled('zone')) {
        $query->where('zone', $request->zone);
    }

    $kids = $query->get();

    $csvData = "Name,Age,Zone,Phone,City,Country,Score,Level,Status,Registration Date\n";
    
    foreach ($kids as $kid) {
        $csvData .= sprintf(
            '"%s",%s,%s,"%s","%s","%s",%s,%s,%s,%s',
            $kid->kid_name,
            $kid->age,
            $kid->zone,
            $kid->phone,
            $kid->city,
            $kid->country,
            $kid->latestCompletedAttempt ? $kid->latestCompletedAttempt->score : '-',
            $kid->latestCompletedAttempt ? $kid->latestCompletedAttempt->level : '-',
            $kid->completedTestAttempts->count() > 0 ? 'Completed' : 'Not Taken',
            $kid->created_at->format('Y-m-d')
        ) . "\n";
    }

    return response($csvData)
        ->header('Content-Type', 'text/csv')
        ->header('Content-Disposition', 'attachment; filename="kids-export-' . now()->format('Y-m-d') . '.csv"');
}




    /* =========================
       DASHBOARD
    ========================= */
    public function dashboard(Request $request)
{
    // ===== CORE COUNTS =====
    $totalStudents = Student::count();
    $totalKids = Kid::count();
    
    $stats = [
        'total_students'  => $totalStudents,
        'total_kids'      => $totalKids, // Add total kids count
        
        // ===== STUDENTS TESTS =====
        'completed_tests' => Student::has('completedTestAttempts')->count(),
        'pending_tests'   => Student::whereHas('inProgressTestAttempt')->count(),
        
        // ===== KIDS TESTS =====
        'kids' => [
            'completed_tests' => Kid::has('completedTestAttempts')->count(),
            'pending_tests'   => Kid::whereHas('inProgressTestAttempt')->count(),
            'total'           => $totalKids,
        ],
        
        'completion_rate' => $totalStudents > 0
            ? round((Student::has('completedTestAttempts')->count() / $totalStudents) * 100, 1)
            : 0,
        
        // ===== RECENT ACTIVITY =====
        'recent_growth' => Student::where('created_at', '>=', now()->subDays(7))->count(),
        'recent_kids_growth' => Kid::where('created_at', '>=', now()->subDays(7))->count(), // Add kids growth
        
        'today_tests' => DB::table('test_attempts')
            ->whereDate('completed_at', today())
            ->where('status', 'completed')
            ->count(),
        
        'today_kids_tests' => DB::table('test_attempts')
            ->whereNotNull('kid_id')
            ->whereDate('completed_at', today())
            ->where('status', 'completed')
            ->count(),
        
        // ===== BRANCHES =====
        'branch_count' => Student::whereNotNull('branch')
            ->distinct('branch')
            ->count('branch'),
        
        // ===== LEVEL DISTRIBUTION (STUDENTS) =====
        'score_distribution' => [
            'beginner' => DB::table('test_attempts')
                ->where('status', 'completed')
                ->where('level', 'Beginner')
                ->count(),
            
            'elementary' => DB::table('test_attempts')
                ->where('status', 'completed')
                ->where('level', 'Elementary')
                ->count(),
            
            'intermediate' => DB::table('test_attempts')
                ->where('status', 'completed')
                ->where('level', 'Intermediate')
                ->count(),
            
            'upper_intermediate' => DB::table('test_attempts')
                ->where('status', 'completed')
                ->where('level', 'Upper Intermediate')
                ->count(),
            
            'advanced' => DB::table('test_attempts')
                ->where('status', 'completed')
                ->where('level', 'Advanced')
                ->count(),
        ],
        
        // ===== KIDS LEVEL DISTRIBUTION =====
        'kids_score_distribution' => [
            'foundation' => DB::table('test_attempts')
                ->whereNotNull('kid_id')
                ->where('status', 'completed')
                ->where('level', 'Foundation')
                ->count(),
            
            'beginner' => DB::table('test_attempts')
                ->whereNotNull('kid_id')
                ->where('status', 'completed')
                ->where('level', 'Beginner')
                ->count(),
        ],
    ];
    
    // ===== STUDENTS LIST =====
    $query = Student::with([
            'latestCompletedAttempt',
            'inProgressTestAttempt',
        ])
        ->withCount('completedTestAttempts');
    
    if ($request->filled('branch')) {
        $query->where('branch', $request->branch);
    }
    
    if ($request->filled('status')) {
        match ($request->status) {
            'completed'   => $query->has('completedTestAttempts'),
            'in_progress' => $query->whereHas('inProgressTestAttempt'),
            'not_taken'   => $query->doesntHave('testAttempts'),
            default       => null,
        };
    }
    
    $students = $query
        ->latest()
        ->paginate(5)
        ->withQueryString();
    
    $branches = Student::whereNotNull('branch')
        ->distinct()
        ->orderBy('branch')
        ->pluck('branch');
    
    // ===== KIDS LIST =====
    $kidsQuery = Kid::with([
        'latestCompletedAttempt',
        'inProgressTestAttempt'
    ])->withCount('completedTestAttempts');
    
    if ($request->filled('status')) {
        match ($request->status) {
            'completed'   => $kidsQuery->has('completedTestAttempts'),
            'in_progress' => $kidsQuery->whereHas('inProgressTestAttempt'),
            'not_taken'   => $kidsQuery->doesntHave('testAttempts'),
            default       => null,
        };
    }
    
    $kids = $kidsQuery->latest()->paginate(5, ['*'], 'kids_page')->withQueryString();
    
    return view('admin.dashboard', compact(
        'stats',
        'students',
        'kids',
        'branches'
    ));
}


    /* =========================
       STUDENTS PAGE
    ========================= */
    public function students(Request $request)
    {
        
        $query = Student::with([
                'latestCompletedAttempt',
                'inProgressTestAttempt'
            ])
            ->withCount('completedTestAttempts');

        if ($request->filled('search')) {
            $query->where(fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
            );
        }

        if ($request->filled('status')) {
            match ($request->status) {
                'completed'   => $query->has('completedTestAttempts'),
                'in_progress' => $query->whereHas('inProgressTestAttempt'),
                'not_taken'   => $query->doesntHave('testAttempts'),
                default       => null
            };
        }

        if ($request->filled('branch')) {
            $query->where('branch', $request->branch);
        }

        $students = $query->paginate(5)->withQueryString();

        $branches = Student::distinct('branch')
            ->whereNotNull('branch')
            ->orderBy('branch')
            ->pluck('branch');

        return view('admin.students', compact('students', 'branches'));
    }

    /* =========================
       STUDENTS PDF
    ========================= */
    public function studentsPdf(Request $request)
    {
        $query = Student::with('latestCompletedAttempt')
            ->withCount('completedTestAttempts');

        if ($request->filled('status')) {
            match ($request->status) {
                'completed' => $query->has('completedTestAttempts'),
                'not_taken' => $query->doesntHave('testAttempts'),
                default     => null
            };
        }

        if ($request->filled('branch')) {
            $query->where('branch', $request->branch);
        }

        $students = $query->orderByDesc('completed_test_attempts_count')->get();

        $pdf = Pdf::loadView('admin.students-pdf', compact('students'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('students-' . now()->format('Y-m-d') . '.pdf');
    }

    /* =========================
       TESTED STUDENTS ONLY
    ========================= */
    public function tested()
    {
        $students = Student::has('completedTestAttempts')
            ->with('latestCompletedAttempt')
            ->latest()
            ->get();

        $branches = Student::distinct('branch')
            ->whereNotNull('branch')
            ->orderBy('branch')
            ->pluck('branch');

        return view('admin.students-tested', compact('students', 'branches'));
    }

    /* =========================
       INDEX (LEGACY PAGE)
    ========================= */
    public function index()
    {
        $students = Student::with([
                'latestCompletedAttempt',
                'inProgressTestAttempt'
            ])
            ->withCount('completedTestAttempts')
            ->orderByDesc('completed_test_attempts_count')
            ->orderBy('name')
            ->paginate(8);

        $totalStudents  = Student::count();
        $completedTests = Student::has('completedTestAttempts')->count();
        $completionRate = $totalStudents > 0
            ? round(($completedTests / $totalStudents) * 100, 1)
            : 0;

        $branches = Student::distinct('branch')
            ->whereNotNull('branch')
            ->orderBy('branch')
            ->pluck('branch');

        return view('admin.students', compact(
            'students',
            'totalStudents',
            'completedTests',
            'completionRate',
            'branches'
        ));
    }

}





