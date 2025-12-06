# TODO: Separate Routes for Admin and User Change-Password Views

## Steps to Complete:
- [ ] Edit routes/web.php: Add middleware('admin') to dashboard change-password routes and add new user routes
- [ ] Edit app/Http/Controllers/DashboardController.php: Add userChangePassword() method
- [ ] Edit resources/views/user/change-password.blade.php: Change form action to 'user.password.update'
- [ ] Edit resources/views/user/sidebar.blade.php: Change link to 'user.change-password'
- [x] Test routes and form submissions
