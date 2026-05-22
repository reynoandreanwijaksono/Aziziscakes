Ekspor Flowchart (Mermaid) — Petunjuk

1) Menggunakan npx (direkomendasikan, tidak perlu instal global):

```bash
npx @mermaid-js/mermaid-cli -i public/flowchart.mmd -o public/flowchart.svg
```

2) Atau pasang global dan jalankan:

```bash
npm install -g @mermaid-js/mermaid-cli
mmdc -i public/flowchart.mmd -o public/flowchart.svg
```

3) Opsi output lain: PNG

```bash
npx @mermaid-js/mermaid-cli -i public/flowchart.mmd -o public/flowchart.png
```

4) Catatan untuk Windows PowerShell: jalankan dari root project (folder yang berisi `public`).

```powershell
cd "d:\KumpulanTugas\Projects\New folder\Aziziscakes"
npx @mermaid-js/mermaid-cli -i public/flowchart.mmd -o public/flowchart.svg
```

File yang dibuat:
- public/flowchart.mmd — sumber Mermaid
- public/flowchart.svg — placeholder (diganti saat render)

Butuh saya jalankan konversi di mesin Anda (memerlukan koneksi & npm), atau cukup buatkan file hasilnya saja?