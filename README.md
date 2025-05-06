# Twitter Clone

This project is a simple clone of Twitter (now known as X), built to replicate core functionalities of a social media platform. It includes features for user interaction and tweet management, with a responsive design for both desktop and mobile devices.

## Features

- **User Registration**: Create an account with a unique username, email, and password.
- **Login System**: Securely log in to access personalized features.
- **Tweet Creation**: Post tweets with text content.
- **Viewing Tweets**: Browse a list of tweets from all users.
- **Tweet Page**: View an individual tweet with its details.
- **Tweet Editing**: Edit the content of your own tweets.
- **Tweet Deletion**: Delete your own tweets.
- **Responsive Design**: Fully responsive layout, optimized for desktop and mobile devices (up to 768px).

## Database Structure

The project uses a MySQL database with the following structure:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tweets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## Project Structure

- **`app/`**: Contains core application files (models, controllers, views).
  - `models/Tweet.php`: Model for tweet-related operations.
  - `controllers/TweetController.php`: Handles tweet CRUD (create, read, update, delete).
  - `views/tweets/`:
    - `show.php`: Template for viewing a single tweet.
    - `edit.php`: Template for editing a tweet.
- **`scss/`**: Modular SCSS files for styling.
  - `base/`: Base styles (reset, container).
  - `components/`: Component-specific styles (sidebar, footer, tweets).
  - `pages/`: Page-specific styles (tweet page, login/register).
  - `utilities/`: Utility styles (validation errors).
- **`public/`**: Public assets (compiled CSS, JavaScript).
  - `js/main.js`: Handles hamburger menu and tweet popup functionality.
- **`gulpfile.js`**: Gulp configuration for compiling SCSS.
