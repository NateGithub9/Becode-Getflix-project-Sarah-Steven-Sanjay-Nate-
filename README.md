# Getflix Project Contribution Overview

### Team Members and Their Roles

- **Sanjay (git: Kendrak90)**

Sanjay developed the front-end user interface using HTML, CSS, and JavaScript. Collaborating with Sarah, he focused on key features aimed at providing an engaging and efficient user experience with well-integrated front-end components.

- **Sarah (git: sabbels)**

Sarah functioned as both a Front-end and Back-end Developer, expertly managing the project using Trello to ensure streamlined progress and effective task delegation. She was instrumental in designing the front-end user interface with HTML, CSS, and JavaScript, and specifically crafted the first page users encounter upon landing on the website, ensuring a captivating initial experience.

Sarah developed functionalities using JavaScript that enabled users to add movies to their profiles, enhancing user engagement and personalization. She collaborated closely with Steven to achieve seamless integration between front-end and back-end components, focusing on features such as movie and series details, filters, and user dashboard functionalities.

Additionally, Sarah designed custom icons and images to enhance the platform's visual appeal and maintained clear, consistent communication to meet project deadlines effectively. She leveraged modern frameworks and libraries to optimize both development efficiency and user experience.

- **Steven (git: stevenmottiaux)**

Steven played a crucial role as the primary Back-end Developer, designing and implementing key systems that enhance user interaction and application functionality. He developed a robust Session Management System to maintain user sessions by tracking activity and preferences, ensuring a seamless user experience. In addition, he implemented User Authentication mechanisms to verify user identities, granting access to authorized users only.

Steven also crafted a sophisticated Roles Management system, providing various permissions and access levels tailored to different user roles, such as admin, member, or guest. He enhanced the interactive component with Comment Handling features, enabling users to post, display, edit, and delete comments smoothly within the application.

His work on Search Algorithms with Dynamic Filtering brought advanced search functionalities to the forefront, allowing users to discover content based on multiple dynamic criteria, thereby improving navigation and content discovery. To support a consistent development environment, Steven utilized Docker, ensuring applications could run reliably across different systems.

Leveraging PHP, Steven built secure and scalable server-side applications, adeptly processing user requests and managing data connections. He employed MySQL for efficient database operations like data storage and retrieval. His dedication to quality was reflected in the comprehensive Unit Testing and Integration Testing he conducted, verifying that each part of the application worked correctly both individually and together.

Furthermore, Steven produced thorough documentation for the application's APIs and systems, providing essential guidance for maintenance and future upgrades. This contributed significantly to the project's sustainability and clarity, demonstrating his commitment to high-quality software development.

- **Nate (git: NateGithub9)**

As the Back-end Developer and Git Master, Nate played a pivotal role in overseeing version control and deployments with meticulous attention to detail. He personally reviewed every commit, ensuring code quality and consistency across the project. Nate formulated a robust deployment strategy using Heroku and was instrumental in the migration of data to the ClearDB SQL database, maintaining data consistency and enhancing security.

Beyond oversight, Nate conducted thorough testing on all implemented features, guaranteeing functionality and reliability before merging branches. His careful handling of branch merges minimized conflicts and streamlined development processes. Nate was also vigilant in managing secure database connections, expertly concealing all sensitive information to bolster data security. His diligent management of Git workflows optimized team collaboration and significantly enhanced productivity.

### Getflix Features

1. **Home Page**

The "Accueil" page welcomes users with an overview of popular movies and features a search bar for easy navigation. It includes navigation options for exploring "Movies," "Shows," and the user profile section.

2. **Profile Page**

Visitors can explore the Getflix library without an account. Upon signing up, users can access a personalized dashboard to:

- Users may sign up to comment and manage their profiles, including editing username, password, email, and uploading a custom profile picture.
- Add comments, viewable in the "Comments" section. Comments can be sorted and filtered by rating, publication date, or alphabetically.
- Change user password.
- Note that only admin users can moderate comments, ensuring quality and listing reasons for refusals in the moderation dashboard.

3. **Movies Pages and Series Page**

- Users can search the Getflix database for movies and series, utilizing a sophisticated filtering system to sort videos by title, date, rating, language, and release date. Video covers link to pages with descriptions and trailers, enhancing user engagement. Logged-in users can add comments, which appear instantly.
- Allows users to search for movies and series by keyword in distinct search bars on the home page, movies page, and series page.
- Users can load additional movies and series, displaying an additional 12 entries each time a button is clicked, with filters applied consistently.
- Offers sorting by title, release date, and rating, in ascending or descending order.

### Potential New Features

1. **Newsletter Integration with Mailchimp**
   - Enable users to sign up for newsletters.

2. **Optimize Performance**
   - Improve performance based on testing outcomes.
