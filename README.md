# webbd.xyz

Click the image below to get redirected to a youtube video showing how the site works - 

[![Webbd.xyz](http://img.youtube.com/vi/SGkeAWxiRp4/0.jpg )](http://www.youtube.com/watch?v=SGkeAWxiRp4 "Webbd.xyz")

<br>

## Site Features

Register and Login
  - Both forms are on the same page, displayed with a toggling link made with JS
  - The register form shows error when user is registering with an existing email, when confirmation email or passwords do not match, email or password is not in the proper format. If an error occurs, appropriate message is displayed. Suitable error message also displayed for the login form
  - Upon registration, a user's profile is set with one of two default profile pictures; username set to **firstname_lastname**
  
Home Page (Newsfeed)
  - Users's profile details are displayed on the left & the feed is positioned in the center.
  - A user can posts statuses on the newsfeed. This post will be available for only friends to see.
  - ***Users can like posts.*** Like count updates every time like or unlike is pressed
  - ***Users can also comment on these posts***, which will be displayed below the post. Can be accessed upon clicking the post or clicking the "Comment" link
  - User have the option to post on other people's profile. In this case, the name bar will show **User1 TO User2** 
  - One can also ***share YouTube videos*** in a post by simply pasting the video link in the post box. The site will automatically embedd the video on the feed.
  - ***Option to delete posts*** shows on the posts made by a user.
  - ***Infinite Scrolling*** to load more posts upon reaching the end of the page. Once reached the end, message displayed "No more posts to show"
  - Appropriate animations and minimal styling applied throughout the page.
  
Messaging System
  - If a users has not made any messages, it takes them to a page where they can ***live search among their friends and choose whom to message***
  - If user already has messaged other users, ***conversation list shows on the left*** of the message page & ***message tab shows on the right***
  - The messages of most recent interaction opens by default.
  - Message tab has a ***chat style interface and users can send messages to other users through a message box and see the entire conversation opened up in the message tab***
  
 Friend System
  - Has options to add other users as friends
  - This will allow users to ***View their posts on their newsfeed, Send them messages & Post on their profile***
  - On another user's profile, ***Friend Request Button toggles between ADD FRIEND, REMOVE FRIEND, RESPOND TO REQUEST & REQUEST SENT*** depending upon the case.
  - ***Friend Request Page shows list of friend requests*** with option to Accept or Ignore; along with a link to check requester's profile

 Profile Page
  - ***Can be accessed by simply typing the username of a user in the URL (.htaccess present file to prevent errors)***
  - Shows user information on the left and the user's wall on the right
  - ***Option to message a friend & option to post on friend's profile*** only shows if UserA is a friend of UserB
  - ***Post Something button*** opens a pop-up form allowing user logged in to write and submit their post on their friend's profile
  - ***Send Message button*** redirectes to the message tab between the user logged in and friend's profile on the message page
