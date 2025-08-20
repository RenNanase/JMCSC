// Check if we should redirect to marketing dashboard after login
document.addEventListener('DOMContentLoaded', function() {
    // Check if user is logged in and has the redirect flag
    if (document.body.classList.contains('logged-in') && localStorage.getItem('redirect_to_marketing') === 'true') {
        // Clear the flag
        localStorage.removeItem('redirect_to_marketing');
        
        // Get the marketing dashboard URL
        const marketingDashboardUrl = document.body.dataset.marketingDashboardUrl;
        
        if (marketingDashboardUrl) {
            // Redirect to marketing dashboard
            window.location.href = marketingDashboardUrl;
        }
    }
}); 