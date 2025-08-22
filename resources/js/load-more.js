document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('load-more-container');
    if (!container) return;
    
    // Gunakan event delegation untuk menangani klik, lebih fleksibel
    container.addEventListener('click', function(e) {
        const loadMoreBtn = e.target.closest('#load-more-btn');
        if (!loadMoreBtn) return;

        e.preventDefault();
        
        const postContainer = document.getElementById('post-container');
        const url = loadMoreBtn.href;
        const spinner = loadMoreBtn.querySelector('.spinner-border');

        spinner.classList.remove('d-none');
        loadMoreBtn.disabled = true;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                postContainer.insertAdjacentHTML('beforeend', data.html);
            }

            // Perbarui URL atau hapus tombol jika tidak ada halaman lagi
            if (data.next_page_url) {
                loadMoreBtn.href = data.next_page_url;
            } else {
                loadMoreBtn.remove();
            }
        })
        .catch(error => console.error('Error loading more posts:', error))
        .finally(() => {
            spinner.classList.add('d-none');
            loadMoreBtn.disabled = false;
        });
    });
});