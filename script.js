// =================================================================
// UKM ESPORT MANAGEMENT SYSTEM - UNIFIED SCRIPT.JS
// Mengelola Landing Page (index.html) & Dashboard Panel (dashboard.html)
// =================================================================

document.addEventListener("DOMContentLoaded", function () {

    // =============================================================
    // 1. LOGIKA LANDING PAGE & INTERAKSI PUBLIK (index.html)
    // =============================================================

    // Change Content Secara Dinamis
    const heroTag = document.querySelector(".hero-text .tag");
    if (heroTag) {
        heroTag.textContent = "Unit Kegiatan Mahasiswa Esports Kampus";
    }

    const heroTitle = document.querySelector(".hero-text h1");
    if (heroTitle) {
        heroTitle.innerHTML = "Wadah Bakat & Prestasi Gaming <span>Mahasiswa</span>";
    }

    const anggotaSubheading = document.querySelector("#anggota .section-heading p");
    if (anggotaSubheading) {
        anggotaSubheading.textContent = "Pusat informasi divisi game kompetitif, daftar pro player, serta talent pendukung UKM.";
    }

    // Interactive Button Events
    const heroButton = document.querySelector(".hero-text .button");
    if (heroButton) {
        heroButton.addEventListener("click", function () {
            const originalText = heroButton.textContent;
            heroButton.textContent = "Memuat Turnamen...";
            setTimeout(() => {
                heroButton.textContent = originalText;
            }, 1200);
        });
    }

    const reportButton = document.querySelector("#laporan .button");
    if (reportButton) {
        reportButton.addEventListener("click", function () {
            alert("🏆 Laporan Prestasi Turnamen & Kas UKM Esport siap diunduh!");
        });
    }

    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.forEach(item => item.style.color = "#94a3b8");
            this.style.color = "#06b6d4";
        });
    });

    // Program Cards Click Event (Detail Box Interaktif)
    const programCards = document.querySelectorAll("#program .card");
    const programContainer = document.querySelector("#program .container");

    if (programCards.length > 0 && programContainer) {
        const detailBox = document.createElement("div");
        detailBox.id = "program-detail-panel";
        detailBox.style.marginTop = "35px";
        detailBox.style.padding = "28px";
        detailBox.style.backgroundColor = "#1e293b";
        detailBox.style.border = "2px solid #06b6d4";
        detailBox.style.borderRadius = "14px";
        detailBox.style.boxShadow = "0 0 25px rgba(6, 182, 212, 0.2)";
        detailBox.style.display = "none";

        programContainer.appendChild(detailBox);

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

                const closeBtn = document.getElementById("close-detail-btn");
                if (closeBtn) {
                    closeBtn.addEventListener("click", function (e) {
                        e.stopPropagation();
                        detailBox.style.display = "none";
                    });
                }
            });
        });
    }

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

    let currentRole = "player"; // Default Role Login

    // Buka Modal Login
    if (openLoginBtn && loginModal) {
        openLoginBtn.addEventListener("click", function () {
            loginModal.classList.add("active");
        });
    }

    // Tutup Modal lewat Tombol X
    if (closeLoginBtn && loginModal) {
        closeLoginBtn.addEventListener("click", function () {
            loginModal.classList.remove("active");
            if (loginMessage) loginMessage.style.display = "none";
        });
    }

    // Tutup Modal jika Klik Latar Belakang Gelap
    if (loginModal) {
        loginModal.addEventListener("click", function (e) {
            if (e.target === loginModal) {
                loginModal.classList.remove("active");
                if (loginMessage) loginMessage.style.display = "none";
            }
        });
    }

    // Tutup Modal dengan Tombol Escape (Esc)
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && loginModal && loginModal.classList.contains("active")) {
            loginModal.classList.remove("active");
            if (loginMessage) loginMessage.style.display = "none";
        }
    });

    // Switch Role (Player vs Pengurus)
    if (roleBtns.length > 0) {
        roleBtns.forEach(btn => {
            btn.addEventListener("click", function () {
                roleBtns.forEach(r => r.classList.remove("active"));
                this.classList.add("active");

                currentRole = this.getAttribute("data-role");

                if (currentRole === "pengurus") {
                    if (labelId) labelId.textContent = "NIM / ID Pengurus";
                    if (loginIdInput) loginIdInput.placeholder = "Contoh: 230101009";
                } else {
                    if (labelId) labelId.textContent = "Game ID / Nickname";
                    if (loginIdInput) loginIdInput.placeholder = "Contoh: RadiantPlayer#1234";
                }
            });
        });
    }

    // Submit Login Form -> Redirect ke dashboard.html
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const username = loginIdInput.value.trim();

            if (username !== "") {
                loginMessage.className = "login-message success";
                loginMessage.textContent = `✅ Login Berhasil! Mengalihkan ke Dashboard...`;

                setTimeout(() => {
                    loginModal.classList.remove("active");
                    loginForm.reset();
                    // Mengarahkan ke dashboard.html membawa data user & role
                    window.location.href = `dashboard.html?role=${currentRole}&user=${encodeURIComponent(username)}`;
                }, 1200);
            } else {
                loginMessage.className = "login-message error";
                loginMessage.textContent = "❌ Harap masukkan Game ID / NIM Anda.";
            }
        });
    }

    // =============================================================
    // 3. LOGIKA DASHBOARD PANEL (dashboard.html)
    // =============================================================

    const userDisplayName = document.getElementById("user-display-name");
    const userDisplayRole = document.getElementById("user-display-role");
    const addScrimBtn = document.getElementById("add-scrim-btn");
    const scrimFormBox = document.getElementById("scrim-form-box");
    const cancelScrimBtn = document.getElementById("cancel-scrim-btn");
    const scrimForm = document.getElementById("scrim-form");
    const scrimTableBody = document.getElementById("scrim-table-body");

    // Mengecek apakah browser sedang berada di halaman dashboard.html
    if (userDisplayName && userDisplayRole) {
        // Ambil Data dari URL Query Parameters
        const urlParams = new URLSearchParams(window.location.search);
        const userParam = urlParams.get('user') || 'Member Esport';
        const roleParam = urlParams.get('role') || 'player';

        // Tampilkan Nama & Role di Profil Sidebar
        userDisplayName.textContent = userParam;

        if (roleParam === "pengurus") {
            userDisplayRole.textContent = "Role: Pengurus UKM";
            userDisplayRole.style.backgroundColor = "#8b5cf6";
            if (addScrimBtn) addScrimBtn.style.display = "inline-block";
        } else {
            userDisplayRole.textContent = "Role: Pro Player";
            userDisplayRole.style.backgroundColor = "#06b6d4";
            // Sembunyikan Tombol Tambah jika pengguna adalah Player biasa
            if (addScrimBtn) addScrimBtn.style.display = "none";
        }

        // Toggle Form Tambah Scrim
        if (addScrimBtn) {
            addScrimBtn.addEventListener("click", function () {
                scrimFormBox.classList.toggle("active");
            });
        }

        if (cancelScrimBtn) {
            cancelScrimBtn.addEventListener("click", function () {
                scrimFormBox.classList.remove("active");
            });
        }

        // Penambahan Scrim Baru ke Tabel
        if (scrimForm && scrimTableBody) {
            scrimForm.addEventListener("submit", function (e) {
                e.preventDefault();

                const opponent = document.getElementById("scrim-opponent").value.trim();
                const game = document.getElementById("scrim-game").value;
                const date = document.getElementById("scrim-date").value;
                const time = document.getElementById("scrim-time").value;

                if (opponent && game && date && time) {
                    const tr = document.createElement("tr");
                    const gameClass = game.toLowerCase().includes("valorant") ? "valorant" : "mlbb";

                    tr.innerHTML = `
                        <td><span class="game-tag ${gameClass}">${game}</span></td>
                        <td>VS ${opponent}</td>
                        <td>${date}, ${time} WIB</td>
                        <td><span class="status status-planned">Direncanakan</span></td>
                        <td><button class="btn-action">Detail Strategy</button></td>
                    `;

                    scrimTableBody.prepend(tr);
                    scrimForm.reset();
                    scrimFormBox.classList.remove("active");
                    alert("✅ Jadwal Scrim Baru Berhasil Ditambahkan!");
                }
            });
        }
    }

});