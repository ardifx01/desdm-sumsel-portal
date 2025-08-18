// resources/js/comment-system.js

document.addEventListener('DOMContentLoaded', function() {
    // Logika untuk tombol "Balas"
    document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Sembunyikan semua form balasan yang mungkin terbuka
            document.querySelectorAll('.reply-form.show').forEach(openForm => {
                // Kecuali jika itu adalah form yang sama
                if (openForm.id !== `reply-form-${this.dataset.commentId}`) {
                    openForm.classList.remove('show');
                }
            });
            
            // Toggle form balasan yang relevan
            const commentId = this.dataset.commentId;
            const form = document.getElementById(`reply-form-${commentId}`);
            if (form) {
                form.classList.toggle('show');
                // Jika form ditampilkan, fokus ke textarea
                if (form.classList.contains('show')) {
                    form.querySelector('textarea').focus();
                }
            }
        });
    });

    // Logika untuk tombol "share" (sudah ada, kita pindahkan ke sini)
    document.querySelectorAll('.share-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const postId = this.dataset.postId;
            const shareUrl = this.getAttribute('href');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Lakukan fetch hanya jika post_id ada
            if (postId && csrfToken) {
                fetch(`/berita/${postId}/share-count`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ post_id: postId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const shareCountEl = document.getElementById('share-count');
                        if (shareCountEl) {
                            shareCountEl.textContent = data.share_count;
                        }
                    }
                })
                .catch(error => console.error('Error updating share count:', error))
                .finally(() => {
                    // Selalu buka window share, bahkan jika fetch gagal
                    window.open(shareUrl, '_blank');
                });
            } else {
                // Jika tidak ada post_id, langsung buka
                window.open(shareUrl, '_blank');
            }
        });
    });
});