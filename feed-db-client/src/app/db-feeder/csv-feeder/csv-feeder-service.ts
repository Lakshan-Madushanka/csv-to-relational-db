import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Subject } from 'rxjs';
import { catchError, tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class CSVFeederService {
  constructor(private http: HttpClient) {}

  uploadCsv(uploadedFile: File) {
    console.log(uploadedFile);
    let formData = new FormData();
    formData.append('file', uploadedFile);
    return this.http.post<{ id: string }>(
      'https://feed-db.io/api/uploads/csv',
      formData
    );
  }

  getProgress(id: string) {
    let param = new HttpParams().set('key', id);
    return this.http.get(
      'https://feed-db.io/api/uploads/csv/progress-details',
      { params: param }
    );
  }
}
