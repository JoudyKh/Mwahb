Mwahb Platform 🌟

Mwahb (meaning "Talents") is a creative discovery and portfolio management platform built with the Laravel framework. The system is designed to provide a digital stage for talented individuals to showcase their skills, share their creative work, and connect with opportunities in a professional environment.

✨ Key Features

Talent Portfolios: Users can create and customize digital portfolios to showcase their works, skills, and achievements.

Media Gallery: Robust handling of various media types (images, videos, documents) for a rich visual presentation.

Discovery Engine: Advanced search and filtering tools to help recruiters or enthusiasts discover talent based on specific categories.

User Interactions: Features like following, liking, or commenting on works to foster community engagement.

Profile Management: Secure user profiles with customizable bios, social links, and contact information.

Admin Supervision: A comprehensive backend dashboard to moderate content and manage the community.

🛠 Technical Stack

Backend: Laravel 10.x

Database: MySQL

Frontend: Blade Templates, CSS/JS, Tailwind CSS.

Architecture: MVC (Model-View-Controller) pattern for scalability.

Asset Management: Integrated Laravel storage for efficient media handling.

🚀 Installation & Setup

To run Mwahb locally, follow these steps:

Clone the Repository:

git clone [https://github.com/JoudyKh/Mwahb.git](https://github.com/JoudyKh/Mwahb.git)
cd Mwahb


Install Composer Dependencies:

composer install


Install Frontend Assets:

npm install && npm run dev


Environment Setup:

Copy .env.example to .env.

Configure your database settings.

php artisan key:generate


Database Migration:

php artisan migrate --seed


Start the Application:

php artisan serve


📂 Project Logic Highlights

Dynamic Content Handling: Efficiently managing large media assets using Laravel's file systems.

User Permission System: Secure access layers ensuring users can only manage their own portfolios.

Relational Data Modeling: Complex Eloquent relationships between users, their talents, and their media entries.

👩‍💻 Developer

Joudy Alkhatib

GitHub: @JoudyKh

LinkedIn: Joudy Alkhatib

Email: joudyalkhatib38@gmail.com

Mwahb - Highlighting the potential of every creative mind.
