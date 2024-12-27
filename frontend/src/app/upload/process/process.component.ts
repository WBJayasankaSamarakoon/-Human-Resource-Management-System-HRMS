import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { apiBaseUrl } from 'src/app/app.config';

@Component({
  selector: 'app-process',
  templateUrl: './process.component.html',
  styleUrls: ['./process.component.scss'],
  standalone: true,
  imports: [CommonModule],
})
export class ProcessComponent implements OnInit {
  fileData: any[] = [];
  pagedData: any[] = [];
  loading: boolean = false;

  // Pagination properties
  currentPage: number = 1;
  pageSize: number = 25;
  totalPages: number = 1;
  pages: number[] = [];

  constructor(private http: HttpClient, private router: Router) {}

  ngOnInit(): void {
    const fileId = localStorage.getItem('fileId');

    if (fileId) {
      this.loadFileData(fileId);
    } else {
      console.error('File ID is missing.');
    }
  }

  loadFileData(fileId: string): void {
    this.loading = true;
    const url = `${apiBaseUrl}api/uploaded_files/${fileId}/view/combined-data`;

    this.http.get<any>(url).subscribe({
      next: (response) => {
        if (response.data && Array.isArray(response.data)) {
          this.fileData = response.data.map((record: any) =>
            this.formatRecord(record)
          );
          this.totalPages = Math.ceil(this.fileData.length / this.pageSize);
          this.pages = Array.from({ length: this.totalPages }, (_, i) => i + 1);
          this.updatePagedData();
        } else {
          console.error(
            response.message || 'No data found for the selected file.'
          );
        }
        this.loading = false;
      },
      error: (err) => {
        console.error('Error fetching file data:', err);
        this.loading = false;
      },
    });
  }

  formatRecord(record: any): any {
    return {
      ...record,
      leave_days: record.leave_days || 0,
      holidays: record.holidays || 0,
      late_hours: record.late_hours || 0,
      basic_salary: record.basic_salary || 0.0,
      total_allowances: record.total_allowances || 0.0,
      deductions: record.deductions || 0.0,
      net_salary: record.net_salary || 0.0,
    };
  }

  updatePagedData(): void {
    const startIndex = (this.currentPage - 1) * this.pageSize;
    const endIndex = startIndex + this.pageSize;
    this.pagedData = this.fileData.slice(startIndex, endIndex);
  }

  changePage(page: number): void {
    if (page < 1 || page > this.totalPages) return;
    this.currentPage = page;
    this.updatePagedData();
  }

  navigateToSlip(empId: string): void {
    this.router.navigate(['/slip'], { queryParams: { emp_id: empId } });
  }

  goBack(): void {
    this.router.navigate(['/view-file']);
  }
}
