import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Program Logic
const loadedPrograms = {};
const expandedPrograms = {};

function escapeHtml(unsafe) {
    return (unsafe || "").toString()
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

window.toggleProgram = async function(programId) {
    const btnText = document.getElementById(`btn-text-${programId}`);
    const btnIcon = document.getElementById(`btn-icon-${programId}`);
    const container = document.getElementById(`activities-container-${programId}`);
    const loader = document.getElementById(`loader-${programId}`);
    const programCard = document.getElementById(`program-${programId}`);
    
    const isExpanded = expandedPrograms[programId];

    // Collapse all other programs
    Object.keys(expandedPrograms).forEach(id => {
        if (id != programId && expandedPrograms[id]) {
            window.collapseProgram(id);
        }
    });

    if (isExpanded) {
        window.collapseProgram(programId);
    } else {
        if (!loadedPrograms[programId]) {
            try {
                if(btnText) btnText.innerText = 'Memuat...';
                if(loader) loader.style.display = 'block';
                
                const response = await axios.get(`/program/${programId}/kegiatan`);
                const allKegiatans = response.data;
                
                let html = '<div class="activities-list custom-scrollbar">';
                allKegiatans.forEach(keg => {
                    const img = keg.foto || 'https://via.placeholder.com/150';
                    const title = escapeHtml(keg.nama);
                    const desc = escapeHtml(keg.deskripsi_lengkap);
                    
                    html += `
                    <div class="activity-item">
                        <img src="${img}" alt="${title}">
                        <div class="activity-info">
                            <h4>${title}</h4>
                            <button class="btn-detail" onclick="openModal('${title.replace(/'/g, "\\'")}', '${img}', '${desc.replace(/'/g, "\\'")}')">Detail</button>
                        </div>
                    </div>`;
                });
                html += '</div>';
                
                container.innerHTML = html;
                loadedPrograms[programId] = true;
            } catch (error) {
                console.error("Failed to fetch kegiatans", error);
                alert("Gagal memuat data.");
            } finally {
                if(loader) loader.style.display = 'none';
            }
        }

        if(btnText) btnText.innerText = 'Tutup';
        if(btnIcon) btnIcon.style.transform = 'rotate(180deg)';
        expandedPrograms[programId] = true;
        
        container.style.display = 'block';
        
        setTimeout(() => {
            const offset = window.innerWidth < 768 ? 20 : 40;
            const top = programCard.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        }, 150);
    }
};

window.collapseProgram = function(programId) {
    const container = document.getElementById(`activities-container-${programId}`);
    const btnText = document.getElementById(`btn-text-${programId}`);
    const btnIcon = document.getElementById(`btn-icon-${programId}`);
    
    if(container) {
        container.style.display = 'none';
    }
    
    if(btnText) btnText.innerText = 'Lihat Kegiatan';
    if(btnIcon) btnIcon.style.transform = 'rotate(0deg)';
    expandedPrograms[programId] = false;
};

window.openModal = function(title, img, desc) {
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalImg').src = img;
    document.getElementById('modalDesc').innerText = desc;
    
    const modal = document.getElementById('activityModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
};

window.closeModal = function(e, force = false) {
    if (force || (e && e.target.id === 'activityModal')) {
        const modal = document.getElementById('activityModal');
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
};

