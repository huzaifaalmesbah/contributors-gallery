(function($) {
    'use strict';

    class WPCGVersionSelector {
        constructor() {
            this.init();
        }

        init() {
            $(document).on('click', '.wpcg-version-input', this.toggleDropdown.bind(this));
            $(document).on('click', '.wpcg-version-item', this.handleVersionChange.bind(this));
            $(document).on('click', (e) => {
                if (!$(e.target).closest('.wpcg-version-dropdown').length) {
                    $('.wpcg-version-dropdown').removeClass('active');
                }
            });
        }

        toggleDropdown(e) {
            const dropdown = $(e.target).closest('.wpcg-version-dropdown');
            $('.wpcg-version-dropdown').not(dropdown).removeClass('active');
            dropdown.toggleClass('active');
        }

        handleVersionChange(e) {
            const item = $(e.target);
            const version = item.data('value');
            const dropdown = item.closest('.wpcg-version-dropdown');
            const input = dropdown.find('.wpcg-version-input');
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