    // resources/js/pejabat-modal.js

    document.addEventListener('DOMContentLoaded', function () {
        const pejabatModal = document.getElementById('pejabatModal');
        
        // Ambil template URL dari data-attribute di tag body
        const urlTemplate = document.body.dataset.pejabatModalUrl;

        // Pastikan modal dan template URL ada sebelum melanjutkan
        if (pejabatModal && urlTemplate) {
            pejabatModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const pejabatId = button.getAttribute('data-pejabat-id');
                
                const modalContent = pejabatModal.querySelector('.modal-content');
                
                // Tampilkan spinner loading
                modalContent.innerHTML = `
                    <div class="modal-body text-center p-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;

                // Bangun URL yang benar dengan mengganti placeholder
                const fetchUrl = urlTemplate.replace('PEJABAT_ID_PLACEHOLDER', pejabatId);

                fetch(fetchUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok. Status: ' + response.status);
                        }
                        return response.text();
                    })
                    .then(html => {
                        modalContent.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching pejabat data:', error);
                        modalContent.innerHTML = `
                            <div class="modal-header">
                                <h5 class="modal-title">Error</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p>Terjadi kesalahan saat memuat data profil.</p>
                            </div>
                        `;
                    });
            });
        }
    });