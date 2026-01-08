<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Recruitment Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo h1 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .logo p {
            color: #7f8c8d;
            font-size: 1rem;
        }

        /* Navigation */
        .nav-menu {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .nav-item {
            background: #3498db;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .nav-item:hover {
            background: #2980b9;
        }

        /* Hero Section */
        .hero {
            background: white;
            padding: 40px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero h2 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .hero p {
            color: #555;
            margin-bottom: 20px;
        }

        .cta-button {
            background: #27ae60;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .cta-button:hover {
            background: #229954;
        }

        /* Services Section */
        .services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .service-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .service-card h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .service-card p {
            color: #666;
            font-size: 0.9rem;
        }

        /* About Section */
        .about {
            background: white;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .about h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .about-item h4 {
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .about-item p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Footer */
        .footer {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }

        .footer p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                flex-direction: column;
                align-items: center;
            }

            .nav-item {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Top Login Bar -->
        {{-- <div style="text-align: right; margin-bottom: 10px;">
            <a href="{{ route('login') }}"
                style="background: #3498db; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">Admin/Staff
                Login</a>
        </div> --}}

        <!-- Header -->
        <header class="header">
            <div class="logo">
                <h1>Company Recruitment Portal</h1>
                <p>Your Gateway to Professional Excellence</p>
            </div>

            <nav class="nav-menu">
                <a href="{{ route('home') }}" class="nav-item">Home</a>
                <a href="{{ route('candidate.search.form') }}" class="nav-item">Candidate Search</a>
                <a href="{{ route('login') }}" class="nav-item">Admin/stuff Login</a>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <h2>Welcome to Our Recruitment Platform</h2>
            <p>We are committed to connecting talented professionals with world-class opportunities.</p>
            <a href="{{ route('candidate.search.form') }}" class="cta-button">Check Application Status</a>
        </section>

        <!-- Services Section -->
        <section class="services">
            <div class="service-card" onclick="window.location.href='{{ route('candidate.search.form') }}'">
                <h3>Candidate Search</h3>
                <p>Search for your application status using your phone number. Get instant updates on your recruitment
                    journey.</p>
            </div>

            <div class="service-card" onclick="window.location.href='{{ route('candidates.index') }}'">
                <h3>All Candidates</h3>
                <p>View all candidates in our system. Track applications and monitor the recruitment pipeline.</p>
            </div>

            <div class="service-card" onclick="window.location.href='{{ route('candidates.hired') }}'">
                <h3>Hired Candidates</h3>
                <p>See our successful hires and celebrate the achievements of our new team members.</p>
            </div>
        </section>

        <!-- About Section -->
        <section class="about">
            <h2>About Our Company</h2>
            <div class="about-grid">
                <div class="about-item">
                    <h4>Our Mission</h4>
                    <p>To connect talented professionals with world-class opportunities and drive innovation across
                        industries.</p>
                </div>

                <div class="about-item">
                    <h4>Our Values</h4>
                    <p>Integrity, Excellence, Innovation, and Commitment to our clients and candidates.</p>
                </div>

                <div class="about-item">
                    <h4>Our Team</h4>
                    <p>A dedicated team of experts with years of experience in talent acquisition.</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">

            <p>&copy; 2026 Company Recruitment Portal. All rights reserved.</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceCards = document.querySelectorAll('.service-card');
            serviceCards.forEach(card => {
                card.addEventListener('click', function() {
                    const link = this.querySelector('a');
                    if (link) {
                        window.location.href = link.href;
                    }
                });
            });
        });
    </script>
</body>

</html>
