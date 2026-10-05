// =================================================================
// UKM ESPORT MANAGEMENT SYSTEM - UNIFIED SCRIPT.JS
// Mengelola Landing Page (index.html) & Dashboard Ketua Umum (dashboard.html)
// =================================================================

document.addEventListener("DOMContentLoaded", function () {

    // =============================================================
    // 1. LOGIKA LANDING PAGE & INTERAKSI PUBLIK (index.html)
    // =============================================================

    // Penyesuaian Teks Dinamis Hero Section
    const heroTag = document.querySelector(".hero-text .tag");
    if (heroTag) {
        heroTag.textContent = "Platform Integrasi Organisasi UKM Esports";
    }

    const heroTitle = document.querySelector(".hero-text h1");
    if (heroTitle) {
        heroTitle.innerHTML = "Satu Wadah Terintegrasi untuk <span>Kelola Organisasi</span>";
    }

    const anggotaSubheading = document.querySelector("#anggota .section-heading p");
    if (anggotaSubheading) {
        anggotaSubheading.textContent = "Pusat informasi divisi game kompetitif, daftar pro player, serta talent pendukung UKM.";
    }

    // Hero Button Click Event
    const heroButton = document.querySelector(".hero-text .button");
    if (heroButton) {
        heroButton.addEventListener("click", function () {
            const originalText = heroButton.textContent;
            heroButton.textContent = "Memuat Sistem...";
            setTimeout(() => {
                heroButton.textContent = originalText;
            }, 1000);
        });
    }

    // Nav Menu Active State
    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.forEach(item => item.style.color = "#94a3b8");
            this.style.color = "#06b6d4";
        });
    });


    // =============================================================
    // TAMBAHKAN KODE API PROGRAM / PROKER DI SINI
    // (Menggantikan blok static card program lama)
    // =============================================================
    const API_URL = "data/program.json";

    function loadProgramDataFromAPI() {
        const landingContainer = document.querySelector("#program .card-grid");
        const dashboardContainer = document.getElementById("proker-grid-container");

        const targetContainer = landingContainer || dashboardContainer;
        if (!targetContainer) return;

        targetContainer.innerHTML = `
            <p style="grid-column: 1/-1; text-align: center; color: #06b6d4; padding: 20px;">
                🔄 Memuat data dari API...
            </p>`;

        fetch(API_URL)
            .then(response => {
                if (!response.ok) throw new Error(`Status: ${response.status}`);
                return response.json();
            })
            .then(dataList => {
                renderProgramCards(dataList, targetContainer);
            })
            .catch(error => {
                console.error("Fetch API Error:", error);
                targetContainer.innerHTML = `
                    <p style="grid-column: 1/-1; text-align: center; color: #ef4444; padding: 20px;">
                        ❌ Gagal terhubung ke API (data/program.json).
                    </p>`;
            });
    }

    function renderProgramCards(data, container) {
        container.innerHTML = "";

        if (data.length === 0) {
            container.innerHTML = `<p style="grid-column: 1/-1; text-align: center;">Tidak ada data program.</p>`;
            return;
        }

        data.forEach(item => {
            let statusClass = "status-planned";
            if (item.status === "Sedang Berjalan" || item.status === "Berjalan") statusClass = "status-running";
            if (item.status === "Terlaksana" || item.status === "Selesai") statusClass = "status-done";

            const cardElement = document.createElement("article");
            cardElement.className = "card";
            cardElement.innerHTML = `
                <div class="card-body">
                    <span class="status ${statusClass}">${item.status || item.kategori}</span>
                    <h3>${item.judul}</h3>
                    <p>${item.deskripsi}</p>
                    <p class="date">📅 ${item.tanggal}</p>
                </div>
            `;

            container.appendChild(cardElement);
        });

        initCardClickEvents();
    }

    function initCardClickEvents() {
        const programCards = document.querySelectorAll("#program .card");
        const programContainer = document.querySelector("#program .container");

        if (programCards.length > 0 && programContainer) {
            let detailBox = document.getElementById("program-detail-panel");
            if (!detailBox) {
                detailBox = document.createElement("div");
                detailBox.id = "program-detail-panel";
                detailBox.style.marginTop = "35px";
                detailBox.style.padding = "28px";
                detailBox.style.backgroundColor = "#1e293b";
                detailBox.style.border = "2px solid #06b6d4";
                detailBox.style.borderRadius = "14px";
                detailBox.style.boxShadow = "0 0 25px rgba(6, 182, 212, 0.2)";
                detailBox.style.display = "none";
                programContainer.appendChild(detailBox);
            }

            programCards.forEach(card => {
                card.style.cursor = "pointer";
                card.addEventListener("click", function () {
                    const statusText = card.querySelector(".status") ? card.querySelector(".status").textContent : "Informasi";
                    const titleText = card.querySelector("h3") ? card.querySelector("h3").textContent : "Detail Event";
                    const descText = card.querySelector("p") ? card.querySelector("p").textContent : "";
                    const dateText = card.querySelector(".date") ? card.querySelector(".date").textContent : "";

                    detailBox.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                            <span class="tag">📌 Detail Turnamen / Event Terpilih</span>
                            <span class="status">${statusText}</span>
                        </div>
                        <h3 style="font-size: 22px; color: #f8fafc; margin-bottom: 10px;">${titleText}</h3>
                        <p style="color: #94a3b8; margin-bottom: 20px; font-size: 15px;">${descText}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center; background-color: #0f172a; padding: 14px 18px; border-radius: 10px; flex-wrap: wrap; gap: 10px;">
                            <span style="font-weight: bold; color: #06b6d4; font-size: 14px;">${dateText}</span>
                            <button id="close-detail-btn" style="background-color: #ef4444; color: #ffffff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                                Tutup Detail
                            </button>
                        </div>
                    `;

                    detailBox.style.display = "block";
                    detailBox.scrollIntoView({ behavior: "smooth", block: "nearest" });

                    document.getElementById("close-detail-btn")?.addEventListener("click", function (e) {
                        e.stopPropagation();
                        detailBox.style.display = "none";
                    });
                });
            });
        }
    }

    // Jalankan fungsi fetch API saat halaman dibuka
    loadProgramDataFromAPI();

    // =============================================================
    // 2. LOGIKA MODAL LOGIN & REDIRECT KE DASHBOARD
    // =============================================================

    const openLoginBtn = document.getElementById("open-login-btn");
    const closeLoginBtn = document.getElementById("close-login-btn");
    const loginModal = document.getElementById("login-modal");
    const roleBtns = document.querySelectorAll(".role-btn");
    const labelId = document.getElementById("label-id");
    const loginIdInput = document.getElementById("login-id");
    const loginForm = document.getElementById("login-form");
    const loginMessage = document.getElementById("login-message");

    let currentRole = "ketua";

    if (openLoginBtn && loginModal) {
        openLoginBtn.addEventListener("click", function () {
            loginModal.classList.add("active");
        });
    }

    if (closeLoginBtn && loginModal) {
        closeLoginBtn.addEventListener("click", function () {
            loginModal.classList.remove("active");
            if (loginMessage) loginMessage.style.display = "none";
        });
    }

    if (loginModal) {
        loginModal.addEventListener("click", function (e) {
            if (e.target === loginModal) {
                loginModal.classList.remove("active");
                if (loginMessage) loginMessage.style.display = "none";
            }
        });
    }

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && loginModal && loginModal.classList.contains("active")) {
            loginModal.classList.remove("active");
            if (loginMessage) loginMessage.style.display = "none";
        }
    });

    if (roleBtns.length > 0) {
        roleBtns.forEach(btn => {
            btn.addEventListener("click", function () {
                roleBtns.forEach(r => r.classList.remove("active"));
                this.classList.add("active");

                currentRole = this.getAttribute("data-role");

                if (currentRole === "ketua") {
                    if (labelId) labelId.textContent = "NIM / ID Ketua Umum";
                    if (loginIdInput) loginIdInput.placeholder = "Contoh: 230101001";
                } else {
                    if (labelId) labelId.textContent = "NIM / Game ID Anggota";
                    if (loginIdInput) loginIdInput.placeholder = "Contoh: 230101012 / Player#1234";
                }
            });
        });
    }

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const username = loginIdInput ? loginIdInput.value.trim() : "";

            if (username !== "") {
                if (loginMessage) {
                    loginMessage.className = "login-message success";
                    loginMessage.textContent = "✅ Akses Diterima! Membuka Portal Ketua Umum...";
                }

                setTimeout(() => {
                    if (loginModal) loginModal.classList.remove("active");
                    loginForm.reset();
                    window.location.href = `dashboard.html?role=${currentRole}&user=${encodeURIComponent(username)}`;
                }, 1000);
            } else {
                if (loginMessage) {
                    loginMessage.className = "login-message error";
                    loginMessage.textContent = "❌ Masukkan ID / NIM Anda terlebih dahulu.";
                }
            }
        });
    }

    // =============================================================
    // 3. LOGIKA DASHBOARD KETUA UMUM (dashboard.html)
    // =============================================================

    const userDisplayName = document.getElementById("user-display-name");
    const userDisplayRole = document.getElementById("user-display-role");
    const navItems = document.querySelectorAll(".sidebar-nav .nav-item");
    const tabContents = document.querySelectorAll(".tab-content");

    if (userDisplayName && userDisplayRole) {
        const urlParams = new URLSearchParams(window.location.search);
        const userParam = urlParams.get('user') || 'Ketua Umum';
        const roleParam = urlParams.get('role') || 'ketua';

        userDisplayName.textContent = userParam;

        if (roleParam === "ketua" || userParam.includes("Ketua")) {
            userDisplayRole.textContent = "Role: Ketua Umum";
            userDisplayRole.className = "role-badge role-ketua";
        } else {
            userDisplayRole.textContent = "Role: Pengurus / Anggota";
            userDisplayRole.className = "role-badge";
            userDisplayRole.style.backgroundColor = "#06b6d4";
        }

        // Navigasi Tab Sidebar
        navItems.forEach(item => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                navItems.forEach(nav => nav.classList.remove("active"));
                this.classList.add("active");

                const targetTab = this.getAttribute("data-tab");
                tabContents.forEach(content => {
                    content.classList.remove("active");
                    if (content.id === `${targetTab}-section`) {
                        content.classList.add("active");
                    }
                });
            });
        });
    }

    // Helper Fungsi Buka/Tutup Modal Pop-Up
    function setupModal(triggerBtnId, modalId) {
        const btn = document.getElementById(triggerBtnId);
        const modal = document.getElementById(modalId);
        if (!btn || !modal) return;

        const closeBtn = modal.querySelector(".modal-close");

        btn.addEventListener("click", function () {
            modal.classList.add("active");
        });

        if (closeBtn) {
            closeBtn.addEventListener("click", function () {
                modal.classList.remove("active");
            });
        }

        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                modal.classList.remove("active");
            }
        });
    }

    // Inisialisasi Modal
    setupModal("btn-open-member-modal", "modal-add-member");
    setupModal("btn-open-task-modal", "modal-add-task");
    setupModal("btn-open-task-modal-2", "modal-add-task");
    setupModal("btn-open-proker-modal", "modal-add-proker");
    setupModal("btn-open-absensi-modal", "modal-add-absensi");

    // Close Modal via ESC Key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            document.querySelectorAll(".modal-overlay.active").forEach(m => m.classList.remove("active"));
        }
    });

    // Checkbox Task Interactive Status Toggle
    document.body.addEventListener("change", function (e) {
        if (e.target && e.target.type === "checkbox" && e.target.closest(".task-item")) {
            const taskItem = e.target.closest(".task-item");
            const label = taskItem.querySelector("label");
            const statusBadge = taskItem.querySelector(".status");

            if (e.target.checked) {
                if (label) label.classList.add("task-completed-text");
                if (statusBadge) {
                    statusBadge.className = "status status-done";
                    statusBadge.textContent = "Selesai";
                }
            } else {
                if (label) label.classList.remove("task-completed-text");
                if (statusBadge) {
                    statusBadge.className = "status status-running";
                    statusBadge.textContent = "In Progress";
                }
            }
        }
    });

    // A. Submit Tambah Anggota Baru
    const formAddMember = document.getElementById("form-add-member");
    const memberTableBody = document.getElementById("member-table-body");
    const statTotalAnggota = document.getElementById("stat-total-anggota");

    if (formAddMember && memberTableBody) {
        formAddMember.addEventListener("submit", function (e) {
            e.preventDefault();
            const nim = document.getElementById("input-nim").value;
            const nama = document.getElementById("input-nama").value;
            const divisi = document.getElementById("select-divisi").value;
            const jabatan = document.getElementById("input-jabatan").value;

            let tagClass = "valorant";
            if (divisi.includes("Legends")) tagClass = "mlbb";
            if (divisi.includes("Caster")) tagClass = "caster";

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${nim}</td>
                <td><strong>${nama}</strong></td>
                <td><span class="game-tag ${tagClass}">Divisi ${divisi}</span></td>
                <td>${jabatan}</td>
                <td><button class="btn-action btn-delete-row">Hapus</button></td>
            `;

            memberTableBody.prepend(tr);

            if (statTotalAnggota) {
                let current = parseInt(statTotalAnggota.textContent) || 68;
                statTotalAnggota.textContent = `${current + 1} Anggota`;
            }

            formAddMember.reset();
            document.getElementById("modal-add-member").classList.remove("active");
        });
    }

    // B. Submit Buat Tugas Baru
    const formAddTask = document.getElementById("form-add-task");
    const taskListContainer = document.getElementById("task-list-container");
    const panitiaTaskList = document.getElementById("panitia-task-list");

    if (formAddTask) {
        formAddTask.addEventListener("submit", function (e) {
            e.preventDefault();
            const title = document.getElementById("input-task-title").value;
            const eventName = document.getElementById("input-task-event").value;
            const pic = document.getElementById("input-task-pic").value;

            const taskId = 'task_' + Date.now();
            const newTaskHTML = `
                <div class="task-item">
                    <input type="checkbox" id="${taskId}">
                    <label for="${taskId}">
                        <strong>${title}</strong>
                        <span class="task-meta">${eventName} • PIC: ${pic}</span>
                    </label>
                    <span class="status status-running">In Progress</span>
                </div>
            `;

            if (taskListContainer) taskListContainer.insertAdjacentHTML('afterbegin', newTaskHTML);
            if (panitiaTaskList) panitiaTaskList.insertAdjacentHTML('afterbegin', newTaskHTML);

            formAddTask.reset();
            document.getElementById("modal-add-task").classList.remove("active");
        });
    }

    // C. Submit Tambah Proker Baru
    const formAddProker = document.getElementById("form-add-proker");
    const prokerGridContainer = document.getElementById("proker-grid-container");
    const statTotalProker = document.getElementById("stat-total-proker");

    if (formAddProker && prokerGridContainer) {
        formAddProker.addEventListener("submit", function (e) {
            e.preventDefault();
            const title = document.getElementById("input-proker-title").value;
            const desc = document.getElementById("input-proker-desc").value;
            const status = document.getElementById("select-proker-status").value;
            const date = document.getElementById("input-proker-date").value;

            let statusClass = "status-planned";
            if (status === "Sedang Berjalan") statusClass = "status-running";
            if (status === "Terlaksana") statusClass = "status-done";

            const cardHTML = `
                <article class="card">
                    <div class="card-body">
                        <span class="status ${statusClass}">${status}</span>
                        <h3>${title}</h3>
                        <p>${desc}</p>
                        <p class="date">📅 Target Selesai: ${date}</p>
                    </div>
                </article>
            `;

            prokerGridContainer.insertAdjacentHTML('afterbegin', cardHTML);

            if (statTotalProker) {
                let current = parseInt(statTotalProker.textContent) || 6;
                statTotalProker.textContent = `${current + 1} Proker`;
            }

            formAddProker.reset();
            document.getElementById("modal-add-proker").classList.remove("active");
        });
    }

    // D. Submit Sesi Absensi Baru
    const formAddAbsensi = document.getElementById("form-add-absensi");
    const absensiTableBody = document.getElementById("absensi-table-body");

    if (formAddAbsensi && absensiTableBody) {
        formAddAbsensi.addEventListener("submit", function (e) {
            e.preventDefault();
            const date = document.getElementById("input-absensi-date").value;
            const eventName = document.getElementById("input-absensi-event").value;
            const target = document.getElementById("input-absensi-target").value;

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${date}</td>
                <td>${eventName}</td>
                <td>0 / ${target}</td>
                <td><strong style="color:#facc15;">0% (Berlangsung)</strong></td>
                <td><button class="btn-action">Unduh Rekap PDF</button></td>
            `;

            absensiTableBody.prepend(tr);
            formAddAbsensi.reset();
            document.getElementById("modal-add-absensi").classList.remove("active");
        });
    }

    // Live Search & Filter Anggota
    const searchInput = document.getElementById("search-member-input");
    const divisionSelect = document.getElementById("filter-division-select");

    function filterMembers() {
        const query = searchInput ? searchInput.value.toLowerCase() : "";
        const division = divisionSelect ? divisionSelect.value : "all";
        const rows = document.querySelectorAll("#member-table-body tr");

        rows.forEach(row => {
            const nimText = row.children[0] ? row.children[0].textContent.toLowerCase() : "";
            const nameText = row.children[1] ? row.children[1].textContent.toLowerCase() : "";
            const divisionText = row.children[2] ? row.children[2].textContent : "";

            const matchesQuery = nimText.includes(query) || nameText.includes(query);
            const matchesDivision = (division === "all") || divisionText.includes(division);

            if (matchesQuery && matchesDivision) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    if (searchInput) searchInput.addEventListener("keyup", filterMembers);
    if (divisionSelect) divisionSelect.addEventListener("change", filterMembers);

    // Delesi Baris Tabel
    document.body.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("btn-delete-row")) {
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                const row = e.target.closest("tr");
                if (row) {
                    row.remove();
                    if (statTotalAnggota) {
                        let current = parseInt(statTotalAnggota.textContent) || 68;
                        if (current > 0) statTotalAnggota.textContent = `${current - 1} Anggota`;
                    }
                }
            }
        }
    });

    // =============================================================
    // LOGIKA LOGOUT
    // =============================================================
    const logoutBtn = document.getElementById("btn-logout");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function (e) {
            e.preventDefault(); // Mencegah reload bawaan tag <a>

            // Tampilkan konfirmasi ke user
            const confirmLogout = confirm("Apakah Anda yakin ingin keluar dari sistem?");
            
            if (confirmLogout) {
                // Arahkan kembali ke halaman test.html
                window.location.href = "test.html";
            }
        });
    }

});