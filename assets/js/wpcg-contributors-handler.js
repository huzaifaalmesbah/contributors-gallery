(function($) {
    'use strict';

    class WPCGVersionSelector {
        constructor() {
            this.init();
        }

        init() {
            $(document).on('change', '.wpcg-version-select', this.handleVersionChange.bind(this));
        }

        handleVersionChange(e) {
            const version = $(e.target).val();
            const container = $(e.target).closest('.wpcg-contributors-wrap');

            $.ajax({
                url: wpcg_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'wpcg_load_contributors',
                    version: version,
                    nonce: wpcg_ajax.nonce
                },
                beforeSend: () => {
                    container.addClass('loading');
                },
                success: (response) => {
                    if (response.success) {
                        const newContent = $(response.data);
                        const currentSelect = container.find('.wpcg-version-select');
                        const selectedVersion = currentSelect.val();
                        
                        // Keep the version select and its value
                        newContent.find('.wpcg-version-select').val(selectedVersion);
                        
                        // Replace the entire container content
                        container.html(newContent.html());
                        
                        // Restore the version select value
                        container.find('.wpcg-version-select').val(selectedVersion);
                    } else {
                        console.error('Error loading contributors:', response.data);
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Ajax error:', error);
                },
                complete: () => {
                    container.removeClass('loading');
                }
            });
        }
    }

    $(document).ready(() => {
        new WPCGVersionSelector();
    });

})(jQuery);