jQuery(document).ready(function($) {
    const searchForm = $('#wpcg-contributor-search');
    const searchResults = $('#wpcg-search-results');
    const loadingTemplate = '<div class="wpcg-loading">Searching...</div>';

    searchForm.on('submit', function(e) {
        e.preventDefault();
        const username = $('#wpcg-search-input').val().trim();

        if (!username) {
            searchResults.html('<div class="wpcg-error">Please enter a username</div>');
            return;
        }

        // Show loading state
        searchResults.html(loadingTemplate);

        // Make AJAX request
        $.ajax({
            url: wpcg_search_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'wpcg_search_contributor',
                nonce: wpcg_search_ajax.nonce,
                username: username
            },
            success: function(response) {
                if (response.success && response.data) {
                    searchResults.html(response.data);
                } else {
                    searchResults.html('<div class="wpcg-error">No results found</div>');
                }
            },
            error: function() {
                searchResults.html('<div class="wpcg-error">An error occurred while searching</div>');
            }
        });
    });
});
