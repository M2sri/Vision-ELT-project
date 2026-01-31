<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>English Placement Test</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/test-style/register.css') }}">
<style>

</style>
</head>

<body>

<div class="wrapper">
<div class="card">

    <!-- HEADER -->
    <div class="header">
        <h1>Vision Learning Center</h1>
        <button class="home-btn" onclick="window.location.href='/'">
            Home
        </button>
    </div>

    <!-- INTRO -->
    <div class="intro">
        <h2>English Placement Test</h2>
        <p>Not sure about your level? Fill this information to start the test.</p>
    </div>

    <!-- LARAVEL ERRORS -->
    @if ($errors->any())
        <div style="background:#ef4444;color:#fff;padding:10px;border-radius:10px;margin-bottom:15px;">
            <ul style="margin-left:15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <form id="placementForm" method="POST" action="{{ route('test.store') }}">
        @csrf


        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Country</label>
            <select name="country" required>
                <option value="">Select country</option>
                @foreach(['Egypt','Saudi Arabia','UAE','Qatar','Kuwait','Other'] as $c)
                    <option value="{{ $c }}" @selected(old('country')==$c)>{{ $c }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" value="{{ old('city') }}" required>
        </div>

        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" min="10" max="70" value="{{ old('age') }}" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" required>
        </div>

        <!-- BRANCH -->
        <div class="form-group full">
            <label>Preferred Branch</label>
            <div class="button-group">

                <div class="radio-btn">
                    <input type="radio" id="branch_Eldoge" name="branch" value="Eldoge"
                        {{ old('branch')=='Eldoge' ? 'checked' : '' }} required>
                    <label for="branch_Eldoge">Eldoge</label>
                </div>

                <div class="radio-btn">
                    <input type="radio" id="branch_nasr" name="branch" value="Nasr City"
                        {{ old('branch')=='Nasr City' ? 'checked' : '' }}>
                    <label for="branch_nasr">Nasr City</label>
                </div>

                <div class="radio-btn">
                    <input type="radio" id="branch_online" name="branch" value="Online"
                        {{ old('branch')=='Online' ? 'checked' : '' }}>
                    <label for="branch_online">Online</label>
                </div>

            </div>
        </div>

        <!-- PREFERRED TIME -->
<div class="form-group full">
    <label>Preferred Time</label>

    <div class="button-group">

        <div class="radio-btn">
            <input
                type="radio"
                id="time_morning"
                name="prefer_time"
                value="Morning"
                {{ old('prefer_time') === 'Morning' ? 'checked' : '' }}
                required
            >
            <label for="time_morning">Morning</label>
        </div>

        <div class="radio-btn">
            <input
                type="radio"
                id="time_afternoon"
                name="prefer_time"
                value="Afternoon"
                {{ old('prefer_time') === 'Afternoon' ? 'checked' : '' }}
            >
            <label for="time_afternoon">Afternoon</label>
        </div>

        <div class="radio-btn">
            <input
                type="radio"
                id="time_evening"
                name="prefer_time"
                value="Evening"
                {{ old('prefer_time') === 'Evening' ? 'checked' : '' }}
            >
            <label for="time_evening">Evening</label>
        </div>

    </div>

    @error('time')
        <small style="color:#ef4444;margin-top:6px;display:block;">
            {{ $message }}
        </small>
    @enderror
</div>


        <button type="submit" class="submit">
            Start Placement Test →
        </button>

    </form>

</div>
</div>

<script>
document.getElementById('placementForm').addEventListener('submit', function(e) {

    // Check radios manually
    const branchChecked = document.querySelector('input[name="branch"]:checked');
    const timeChecked   = document.querySelector('input[name="prefer_time"]:checked');

    if (!branchChecked || !timeChecked) {
        e.preventDefault();
        alert('Please select branch and preferred time.');
    }
});
</script>

</body>

</html>