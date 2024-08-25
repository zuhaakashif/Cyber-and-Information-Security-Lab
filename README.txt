### README

# UniShelf

## Overview

This Kotlin-based Android application is designed to enhance the academic experience for university students by allowing them to effortlessly discover and access course materials for their current semester. With a user-friendly interface, Firebase authentication, and a variety of resources, this app ensures that students have all the materials they need at their fingertips.

## Features

- **User Authentication with Firebase:** Sign up and log in using Firebase for secure and seamless access.
- **Semester Selection:** After signing in, users can select their current semester, and the app will display all the courses available for that semester.
- **Course Materials:** Each course offers multiple resources:
  - **Books**
  - **Past Papers**
  - **Course Outlines**
  - **Notes**
- **Dark Mode:** Users can view books in dark mode, making it easier to read in low-light environments.

## Screenshots

-----------

![Screenshot](https://github.com/zuhaakashif/UniShelf/blob/main/unishelf-1.jpg)

-----------------------------------------------

![Screenshot](https://github.com/zuhaakashif/UniShelf/blob/main/unishelf-2.jpg)

---------------------------------------------

![Screenshot](https://github.com/zuhaakashif/UniShelf/blob/main/unishelf-3.jpg)

--------------------------------------------------

![Screenshot](https://github.com/zuhaakashif/UniShelf/blob/main/unishelf-4.jpg)

--------------------------------------------------

![Screenshot](https://github.com/zuhaakashif/UniShelf/blob/main/unishelf-5.jpg)

--------------------------------------------------
## Installation

### Prerequisites

- **Android Studio**: Ensure that you have the latest version of Android Studio installed.
- **Kotlin Support**: The project is developed using Kotlin, so make sure Kotlin is enabled in your Android Studio.

### Steps

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/university-course-materials-app.git
   ```
2. **Open the Project in Android Studio:**
   - Launch Android Studio.
   - Select "Open an existing Android Studio project" and navigate to the cloned repository.
   
3. **Sync Project with Gradle Files:**
   - Android Studio will prompt you to sync the project with Gradle files. Click "Sync Now."

4. **Configure Firebase:**
   - Go to [Firebase Console](https://console.firebase.google.com/).
   - Create a new project and add an Android app to your project.
   - Download the `google-services.json` file and place it in the `app/` directory of your Android project.
   - Add Firebase authentication and Firestore to your project.

5. **Run the App:**
   - Once everything is set up, click the "Run" button to install the app on an emulator or physical device.

## Usage

1. **Sign Up/Login:**
   - Users can create a new account or log in with their existing credentials using Firebase Authentication.

2. **Select Semester:**
   - After logging in, the app will prompt users to select their current semester. This selection will filter the courses displayed.

3. **Browse Course Materials:**
   - The app will display a list of courses based on the selected semester.
   - Clicking on a course will show options for Books, Past Papers, Course Outlines, and Notes.

4. **Dark Mode:**
   - Users can enable dark mode for a better reading experience, especially when viewing books.

## Technologies Used

- **Kotlin:** The primary programming language used for Android development.
- **Firebase:** For user authentication and real-time database.
- **Material Design:** For a clean and intuitive user interface.
- **Dark Mode:** Implemented using Android's built-in dark theme support.

## Contributing

Contributions are welcome! Please fork this repository and submit a pull request for any improvements or bug fixes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

For any questions or feedback, feel free to contact:

- **Zuha Fatima & Humna Ali**
- **Email:** zuha.fatima317@gmail.com

---

*This README provides a comprehensive guide to the app, ensuring that anyone who wishes to use, install, or contribute to the project can do so easily.*
