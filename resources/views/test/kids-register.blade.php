<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kids English Test - Fun Learning Adventure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Base Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --secondary: #f59e0b;
            --secondary-light: #fbbf24;
            --success: #10b981;
            --danger: #ef4444;
            --purple: #8b5cf6;
            --pink: #ec4899;
            --bg-soft: #f8fafc;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-light: #64748b;
            --radius-lg: 20px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 15px 35px rgba(99, 102, 241, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #fef7ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text);
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Elements */
        .decoration {
            position: fixed;
            z-index: -1;
        }

        .decoration-1 {
            top: 10%;
            left: 5%;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-light), var(--purple));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            opacity: 0.15;
            animation: float 20s infinite ease-in-out;
        }

        .decoration-2 {
            bottom: 15%;
            right: 8%;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, var(--secondary), var(--pink));
            border-radius: 50%;
            opacity: 0.1;
            animation: float 15s infinite ease-in-out reverse;
        }

        .decoration-3 {
            top: 20%;
            right: 15%;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--success), var(--primary));
            border-radius: 40% 60% 60% 40% / 40% 40% 60% 60%;
            opacity: 0.1;
            animation: float 25s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .wrapper {
            width: 100%;
            max-width: 500px;
            perspective: 1000px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--radius-lg);
            padding: 40px 30px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transform-style: preserve-3d;
            animation: cardEntrance 0.8s ease-out;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(30px) rotateX(-10deg);
            }
            to {
                opacity: 1;
                transform: translateY(0) rotateX(0);
            }
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .logo-container {
            position: relative;
            margin-bottom: 20px;
            display: inline-block;
        }

        .logo-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: var(--secondary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .logo {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary), var(--purple));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
            border: 5px solid white;
            overflow: hidden;
        }

        .logo img {
            max-width: 80px;
            max-height: 80px;
            filter: brightness(0) invert(1);
        }

        .intro h2 {
            font-family: 'Fredoka One', cursive;
            font-size: 2.2rem;
            background: linear-gradient(135deg, var(--primary), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .intro p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 300px;
            margin: 0 auto;
        }

        /* Zone Selection */
        .zones {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .zone {
            background: white;
            border-radius: var(--radius-md);
            padding: 25px 20px;
            cursor: pointer;
            transition: var(--transition);
            border: 3px solid var(--border);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .zone::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--purple));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .zone:hover::before {
            transform: scaleX(1);
        }

        .zone-1 {
            border-color: rgba(99, 102, 241, 0.3);
        }

        .zone-2 {
            border-color: rgba(245, 158, 11, 0.3);
        }

        .zone:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .zone.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
        }

        .zone.active.zone-2 {
            border-color: var(--secondary);
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(251, 191, 36, 0.05));
        }

        .zone-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 36px;
            transition: var(--transition);
        }

        .zone-1 .zone-icon {
            background: linear-gradient(135deg, var(--primary-light), var(--purple));
            color: white;
        }

        .zone-2 .zone-icon {
            background: linear-gradient(135deg, var(--secondary-light), var(--pink));
            color: white;
        }

        .zone h3 {
            font-family: 'Fredoka One', cursive;
            font-size: 1.5rem;
            margin-bottom: 8px;
            color: var(--text);
        }

        .zone span {
            font-size: 1rem;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .zone-tag {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .zone-2 .zone-tag {
            background: rgba(245, 158, 11, 0.1);
            color: var(--secondary);
        }

        /* Form */
        .form-container {
            position: relative;
        }

        #kidsForm {
            display: none;
            animation: formSlide 0.5s ease-out;
        }

        #kidsForm.visible {
            display: block;
        }

        @keyframes formSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px dashed var(--border);
        }

        .form-header-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--purple));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .form-header h3 {
            font-family: 'Fredoka One', cursive;
            font-size: 1.8rem;
            color: var(--text);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text);
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 1rem;
            transition: var(--transition);
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-group input:hover {
            border-color: var(--primary-light);
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--primary), var(--purple));
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Fredoka One', cursive;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .submit-btn i {
            font-size: 1.4rem;
        }

        /* Back Button */
        .back-btn {
            position: absolute;
            top: -50px;
            left: 0;
            background: white;
            border: 2px solid var(--border);
            color: var(--text-light);
            padding: 10px 20px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .back-btn:hover {
            background: var(--bg-soft);
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card {
                padding: 30px 20px;
            }
            
            .intro h2 {
                font-size: 1.8rem;
            }
            
            .zones {
                grid-template-columns: 1fr;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .decoration {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 25px 15px;
            }
            
            .intro h2 {
                font-size: 1.5rem;
            }
            
            .zone {
                padding: 20px 15px;
            }
            
            .zone-icon {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<!-- Decorative Background Elements -->
<div class="decoration decoration-1"></div>
<div class="decoration decoration-2"></div>
<div class="decoration decoration-3"></div>

<div class="wrapper">
    <div class="card">
        <!-- Header -->
        <div class="header">
            <div class="logo-container">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo1.jpg') }}" alt="Logo">
                </div>
                <div class="logo-badge">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            
            <div class="intro">
                <h2>English Learning Adventure!</h2>
                <p>Choose your path and start your magical journey</p>
            </div>
        </div>

        <!-- Zone Selection -->
        <div class="zones" id="zoneSelection">
            <div class="zone zone-1" onclick="selectZone('zone1')">
                <div class="zone-icon">
                    <i class="fa-solid fa-child-reaching"></i>
                </div>
                <h3>Little Explorers</h3>
                <span>Perfect for ages 5 – 8</span>
                <div class="zone-tag">Beginner Level</div>
            </div>

            <div class="zone zone-2" onclick="selectZone('zone2')">
                <div class="zone-icon">
                    <i class="fa-solid fa-children"></i>
                </div>
                <h3>Young Adventurers</h3>
                <span>Perfect for ages 9 – 11</span>
                <div class="zone-tag">Intermediate Level</div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="back-btn" onclick="goBackToZones()" style="display: none;">
                <i class="fas fa-arrow-left"></i>
                Back to Levels
            </div>

            <!-- Registration Form -->
            <form id="kidsForm" method="POST" action="{{ route('kids.store') }}">
                @csrf
                <input type="hidden" name="zone" id="zoneInput">

                <div class="form-header">
                    <div class="form-header-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3>Join the Adventure!</h3>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-user-circle"></i> Kid's Name</label>
                        <input type="text" name="kid_name" required placeholder="Enter your name">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-birthday-cake"></i> Age</label>
                        <input type="number" name="age" min="5" max="11" required placeholder="Your age">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Parent's Phone</label>
                        <input type="tel" name="phone" required placeholder="Phone number">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-globe"></i> Country</label>
                        <input type="text" name="country" required placeholder="Your country">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-city"></i> City</label>
                        <input type="text" name="city" required placeholder="Your city">
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    Start Adventure! 
                    <i class="fas fa-rocket"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let selectedZone = null;

function selectZone(zone) {

    // 🚫 Zone 2 blocked
    if (zone === 'zone2') {
        alert('Zone 2 is coming soon 🚧');
        return;
    }

    selectedZone = zone;
    document.getElementById('zoneInput').value = zone;

    document.querySelectorAll('.zone').forEach(z => z.classList.remove('active'));
    document.querySelector('.zone-1').classList.add('active');

    document.getElementById('kidsForm').classList.add('visible');
    document.querySelector('.back-btn').style.display = 'flex';
    document.getElementById('zoneSelection').style.display = 'none';

    document.querySelector('.form-header h3').textContent =
        "Join Little Explorers!";
}

/* ✅ DO NOT PREVENT SUBMIT */
document.getElementById('kidsForm').addEventListener('submit', function () {

    const submitBtn = this.querySelector('.submit-btn');
    submitBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin"></i> Starting Adventure...';
    submitBtn.disabled = true;

});
</script>



</body>
</html>