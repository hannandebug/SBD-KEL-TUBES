// User Authentication Management
class UserAuth {
    constructor() {
        this.currentUser = this.loadUser();
        this.initializeDemoUser();
    }

    // Initialize demo user if no user exists
    initializeDemoUser() {
        if (!localStorage.getItem('meetupUser')) {
            const demoUser = {
                id: 1,
                fullname: 'Demo User',
                email: 'demo@example.com',
                location: 'San Francisco, USA',
                joinDate: 'March 2024',
                avatar: 'DU',
                bio: 'Demo account for testing',
                interests: ['Technology', 'Web Dev', 'Networking'],
                groupsJoined: 5,
                eventsAttended: 12,
                friends: 45
            };
            localStorage.setItem('meetupDemoUser', JSON.stringify(demoUser));
        }
    }

    // Load user from localStorage
    loadUser() {
        const userJson = localStorage.getItem('meetupUser');
        return userJson ? JSON.parse(userJson) : null;
    }

    // Save user to localStorage
    saveUser(userData) {
        localStorage.setItem('meetupUser', JSON.stringify(userData));
        this.currentUser = userData;
    }

    // Sign up a new user
    signup(fullname, email, password, location) {
        const newUser = {
            id: Date.now(),
            fullname: fullname,
            email: email,
            location: location,
            joinDate: new Date().toLocaleDateString(),
            avatar: fullname.substring(0, 2).toUpperCase(),
            bio: 'New member of Meetup community',
            interests: [],
            groupsJoined: 0,
            eventsAttended: 0,
            friends: 0
        };
        this.saveUser(newUser);
        return newUser;
    }

    // Login user (verify email and password)
    login(email, password) {
        // Check registered users
        const userJson = localStorage.getItem('meetupUser');
        if (userJson) {
            const user = JSON.parse(userJson);
            if (user.email === email) {
                this.currentUser = user;
                return user;
            }
        }
        
        // Check demo account
        if (email === 'demo@example.com' || email === 'demo') {
            const demoUserJson = localStorage.getItem('meetupDemoUser');
            if (demoUserJson) {
                const demoUser = JSON.parse(demoUserJson);
                this.currentUser = demoUser;
                localStorage.setItem('meetupUser', JSON.stringify(demoUser));
                return demoUser;
            }
        }
        
        return null;
    }

    // Logout user
    logout() {
        this.currentUser = null;
        localStorage.removeItem('meetupUser');
    }

    // Check if user is logged in
    isLoggedIn() {
        return this.currentUser !== null;
    }

    // Get current user
    getCurrentUser() {
        return this.currentUser;
    }
}

// Initialize global user auth
const userAuth = new UserAuth();

// Update header based on login status
function updateHeader() {
    const headerButtons = document.querySelector('.header-buttons');
    if (!headerButtons) return;

    if (userAuth.isLoggedIn()) {
        const user = userAuth.getCurrentUser();
        headerButtons.innerHTML = `
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 10px; color: #333; font-size: 14px;">
                    <span style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px; cursor: pointer;" onclick="goToProfile()">
                        ${user.avatar}
                    </span>
                    <span>${user.fullname}</span>
                </div>
                <button class="btn btn-secondary" onclick="logoutUser()" style="padding: 8px 16px; font-size: 13px;">Logout</button>
            </div>
        `;
    } else {
        headerButtons.innerHTML = `
            <a href="/profile" class="btn btn-secondary">Profile</a>
            <button class="btn btn-secondary" onclick="openLoginModal()">Log In</button>
            <button class="btn btn-primary" onclick="openSignupModal()">Sign Up</button>
        `;
    }
}

// Go to profile page
function goToProfile() {
    window.location.href = '/profile';
}

// Logout user
function logoutUser() {
    if (confirm('Are you sure you want to logout?')) {
        userAuth.logout();
        updateHeader();
        alert('You have been logged out successfully!');
    }
}

// Initialize header on page load
document.addEventListener('DOMContentLoaded', function() {
    updateHeader();
});
