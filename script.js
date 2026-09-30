// =================================================================
// UKM ESPORT MANAGEMENT SYSTEM - SCRIPT.JS
// Pertemuan 3: Select & Change, Handle User Event, Complete Interaction
// =================================================================

document.addEventListener("DOMContentLoaded", function () {

    // =============================================================
    // TASK 01 — SELECT & CHANGE
    // Mengambil (select) elemen dan mengubah (change) kontennya
    // =============================================================

    // 1. Select & Change Tag Badge di Hero Section
    const heroTag = document.querySelector(".hero-text .tag");
    if (heroTag) {
        heroTag.textContent = "Unit Kegiatan Mahasiswa Esports Kampus";
    }

    // 2. Select & Change Judul Utama h1 di Hero Section
    const heroTitle = document.querySelector(".hero-text h1");
    if (heroTitle) {
        heroTitle.innerHTML = "Wadah Bakat & Prestasi Gaming <span>Mahasiswa</span>";
    }

    // 3. Select & Change Sub-deskripsi pada Section Anggota / Divisi Game
    const anggotaSubheading = document.querySelector("#anggota .section-heading p");
    if (anggotaSubheading) {
        anggotaSubheading.textContent = "Pusat informasi divisi game kompetitif, daftar pro player, serta talent pendukung UKM.";
    }


    // =============================================================
    // TASK 02 — HANDLE USER EVENT
    // Menangkap aksi pengguna (click, input, dll) & memberi UI Response
    // =============================================================

    // 1. EVENT CLICK: Tombol "Lihat Turnamen" di Hero Section
    const heroButton = document.querySelector(".hero-text .button");
    if (heroButton) {
        heroButton.addEventListener("click", function (event) {
            const originalText = heroButton.textContent;
            heroButton.textContent = "Memuat Turnamen...";

            setTimeout(() => {
                heroButton.textContent = originalText;
            }, 1200);
        });
    }

    // 2. EVENT CLICK: Tombol "Lihat Laporan" pada Section Laporan
    const reportButton = document.querySelector("#laporan .button");
    if (reportButton) {
        reportButton.addEventListener("click", function () {
            alert("🏆 Laporan Prestasi Turnamen & Kas UKM Esport siap diunduh!");
        });
    }

    // 3. EVENT CLICK: Navigasi Menu Header (Menandai Menu Aktif)
    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.forEach(item => item.style.color = "#94a3b8");
            this.style.color = "#06b6d4";
        });
    });


    // =============================================================
    // TASK 03 — BUILD ONE COMPLETE INTERACTION
    // Detail Program Kerja / Turnamen Terpilih saat Card Diklik
    // =============================================================

    const programCards = document.querySelectorAll("#program .card");
    const programContainer = document.querySelector("#program .container");

    const detailBox = document.createElement("div");
    detailBox.id = "program-detail-panel";
    detailBox.style.marginTop = "35px";
    detailBox.style.padding = "28px";
    detailBox.style.backgroundColor = "#1e293b";
    detailBox.style.border = "2px solid #06b6d4";
    detailBox.style.borderRadius = "14px";
    detailBox.style.boxShadow = "0 0 25px rgba(6, 182, 212, 0.2)";
    detailBox.style.display = "none";

    if (programContainer) {
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

            const closeBtn = document.getElementById("close-detail-btn");
            if (closeBtn) {
                closeBtn.addEventListener("click", function (e) {
                    e.stopPropagation();
                    detailBox.style.display = "none";
                });
            }
        });
    });

});