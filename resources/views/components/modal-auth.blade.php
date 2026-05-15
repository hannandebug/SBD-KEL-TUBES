<!-- Modal Styles and Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease-in-out;
        backdrop-filter: blur(4px);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        position: relative;
        animation: slideUp 0.3s ease-in-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .close-btn {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 28px;
        font-weight: bold;
        color: #999;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-btn:hover {
        color: #333;
    }

    .modal-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .modal-header h1 {
        font-size: 28px;
        color: #333;
        margin: 0 0 5px 0;
        font-weight: 600;
    }

    .modal-header p {
        color: #999;
        margin: 0;
        font-size: 14px;
    }

    .social-login {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
        justify-content: center;
    }

    .social-btn {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        background: white;
        cursor: pointer;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .social-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .social-btn.google {
        color: #DB4437;
    }

    .social-btn.facebook {
        color: #1877F2;
    }

    .divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
        color: #999;
        font-size: 12px;
    }

    .divider:before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #e0e0e0;
        z-index: 0;
    }

    .divider span {
        background: white;
        padding: 0 10px;
        position: relative;
        z-index: 1;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }

    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .error-message {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-top: 10px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .modal-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #666;
    }

    .modal-footer a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }

    .modal-footer a:hover {
        text-decoration: underline;
    }

    .category-dropdown {
        position: relative;
        display: inline-block;
    }

    .category-dropdown-btn {
        padding: 6px 12px;
        background: #f0f0f0;
        border: none;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .category-dropdown-btn:hover {
        background: #667eea;
        color: white;
    }

    .category-dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 200px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 12px 0;
        z-index: 1;
        border-radius: 6px;
        top: 100%;
        left: 0;
        margin-top: 5px;
    }

    .category-dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 13px;
        transition: all 0.3s;
    }

    .category-dropdown-content a:hover {
        background-color: #f0f0f0;
        padding-left: 20px;
    }

    .category-dropdown:hover .category-dropdown-content {
        display: block;
    }

    .navbar-categories {
        display: flex;
        gap: 15px;
        margin-left: auto;
        margin-right: 30px;
    }

    @media (max-width: 768px) {
        .navbar-categories {
            margin-left: 0;
            margin-right: 0;
        }

        .modal-content {
            max-width: 90%;
        }
    }
</style>

<script>
    function openLoginModal() {
        document.getElementById('loginModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeLoginModal() {
        document.getElementById('loginModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function openRegisterModal() {
        document.getElementById('registerModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeRegisterModal() {
        document.getElementById('registerModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function switchToLoginModal() {
        closeRegisterModal();
        openLoginModal();
    }

    function switchToRegisterModal() {
        closeLoginModal();
        openRegisterModal();
    }

    window.onclick = function(event) {
        let loginModal = document.getElementById('loginModal');
        let registerModal = document.getElementById('registerModal');
        
        if (event.target == loginModal) {
            closeLoginModal();
        }
        if (event.target == registerModal) {
            closeRegisterModal();
        }
    }
</script>
