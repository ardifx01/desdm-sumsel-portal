// resources/js/admin/photo-upload.js

// Daftarkan komponen ke window agar bisa diakses oleh Alpine.js dari mana saja
window.fileUploadComponent = function() {
    return {
        dragging: false,
        files: [],
        addFiles(fileList) {
            Array.from(fileList).forEach(file => {
                if (file.type.startsWith('image/')) {
                    file.preview = URL.createObjectURL(file);
                    this.files.push(file);
                }
            });
            this.updateFileInput();
        },
        dropFiles(event) {
            this.dragging = false;
            this.addFiles(event.dataTransfer.files);
        },
        removeFile(index) {
            URL.revokeObjectURL(this.files[index].preview);
            this.files.splice(index, 1);
            this.updateFileInput();
        },
        updateFileInput() {
            const dataTransfer = new DataTransfer();
            this.files.forEach(file => dataTransfer.items.add(file));
            this.$refs.fileInput.files = dataTransfer.files;
        }
    }
}