// =================================================================
// ORGANIZATION MANAGEMENT SYSTEM - SCRIPT.JS
// Pertemuan 3: Select & Change, Handle User Event, Complete Interaction
// =================================================================

document.addEventListener("DOMContentLoaded", function () {

    // =============================================================
    // TASK 01 — SELECT & CHANGE
    // Mengambil (select) elemen dan mengubah (change) kontennya
    // =============================================================

    // 1. Select & Change Tag Badge di Hero Section (Selector Class)
    const heroTag = document.querySelector(".hero-text .tag");
    if (heroTag) {
        heroTag.textContent = "Platform Terpadu Organisasi";
    }

    // 2. Select & Change Judul Utama h1 di Hero Section (Selector Tag & innerHTML)
    const heroTitle = document.querySelector(".hero-text h1");
    if (heroTitle) {
        heroTitle.innerHTML = "Kelola Aktivitas Organisasi dalam <span>Satu Tempat</span>";
    }

    // 3. Select & Change Sub-deskripsi pada Section Anggota (Selector ID + Class)
    const anggotaSubheading = document.querySelector("#anggota .section-heading p");
    if (anggotaSubheading) {
        anggotaSubheading.textContent = "Pusat data anggota, struktur divisi, serta deskripsi tanggung jawab pengurus.";
    }


    // =============================================================
    // TASK 02 — HANDLE USER EVENT
    // Menangkap aksi pengguna (click, input, dll) & memberi UI Response
    // =============================================================

    // 1. EVENT CLICK: Tombol "Lihat Program Kerja" di Hero Section
    const heroButton = document.querySelector(".hero-text .button");
    if (heroButton) {
        heroButton.addEventListener("click", function (event) {
            // UI Response 1: Mengubah teks tombol secara sementara
            const originalText = heroButton.textContent;
            heroButton.textContent = "Menuju Program...";

            setTimeout(() => {
                heroButton.textContent = originalText;
            }, 1200);
        });
    }

    // 2. EVENT CLICK: Tombol "Lihat Laporan" pada Section Laporan
    const reportButton = document.querySelector("#laporan .button");
    if (reportButton) {
        reportButton.addEventListener("click", function () {
            // UI Response: Menampilkan alert konfirmasi laporan
            alert("📄 Laporan Organisasi versi terbaru siap diunduh/ditinjau!");
        });
    }

    // 3. EVENT CLICK: Navigasi Menu Header (Menandai Menu Aktif)
    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            // UI Response: Memberi highlight warna pada menu yang diklik
            navLinks.forEach(item => item.style.color = "#374151");
            this.style.color = "#2563eb";
        });
    });


    // =============================================================
    // TASK 03 — BUILD ONE COMPLETE INTERACTION
    // Fitur Interaktif Lengkap: Detail Program Kerja Dinamis saat Card Diklik
    // =============================================================

    // 1. Select Elemen Card pada Section Program
    const programCards = document.querySelectorAll("#program .card");
    const programContainer = document.querySelector("#program .container");

    // 2. Buat Wadah (Container) Detail Program secara Dinamis di DOM
    const detailBox = document.createElement("div");
    detailBox.id = "program-detail-panel";
    detailBox.style.marginTop = "35px";
    detailBox.style.padding = "28px";
    detailBox.style.backgroundColor = "#ffffff";
    detailBox.style.border = "2px solid #2563eb";
    detailBox.style.borderRadius = "14px";
    detailBox.style.boxShadow = "0 10px 25px rgba(37, 99, 235, 0.1)";
    detailBox.style.display = "none"; // Disembunyikan terlebih dahulu

    // Masukkan wadah detail ke dalam container section program
    if (programContainer) {
        programContainer.appendChild(detailBox);
    }

    // 3. Jalankan Interaksi Lengkap saat Salah Satu Kartu Diklik
    programCards.forEach(card => {
        card.style.cursor = "pointer"; // Menandai kartu bisa diklik

        card.addEventListener("click", function () {
            // A. Ambil data dari kartu yang diklik pengguna (Select)
            const statusText = card.querySelector(".status") ? card.querySelector(".status").textContent : "Informasi";
            const titleText = card.querySelector("h3") ? card.querySelector("h3").textContent : "Detail Program";
            const descText = card.querySelectorAll("p")[0] ? card.querySelectorAll("p")[0].textContent : "";
            const dateText = card.querySelector(".date") ? card.querySelector(".date").textContent : "";

            // B. Perbarui tampilan wadah detail dengan data tersebut (DOM Update / Change)
            detailBox.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                    <span class="tag">📌 Detail Program Terpilih</span>
                    <span class="status">${statusText}</span>
                </div>
                <h3 style="font-size: 22px; color: #172033; margin-bottom: 10px;">${titleText}</h3>
                <p style="color: #64748b; margin-bottom: 20px; font-size: 15px;">${descText}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; background-color: #f8fafc; padding: 14px 18px; border-radius: 10px; flex-wrap: wrap; gap: 10px;">
                    <span style="font-weight: bold; color: #172033; font-size: 14px;">${dateText}</span>
                    <button id="close-detail-btn" style="background-color: #ef4444; color: #ffffff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                        Tutup Detail
                    </button>
                </div>
            `;

            // C. Tampilkan Wadah Detail di Halaman (UI Response)
            detailBox.style.display = "block";

            // Scroll halus menuju ke tampilan detail
            detailBox.scrollIntoView({ behavior: "smooth", block: "nearest" });

            // D. Tambahkan fungsi tombol "Tutup Detail"
            const closeBtn = document.getElementById("close-detail-btn");
            if (closeBtn) {
                closeBtn.addEventListener("click", function (e) {
                    e.stopPropagation(); // Mencegah pemicu event klik card
                    detailBox.style.display = "none";
                });
            }
        });
    });

});