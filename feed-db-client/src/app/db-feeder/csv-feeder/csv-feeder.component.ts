import { HttpClient } from '@angular/common/http';
import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { Observable, Subject } from 'rxjs';
import { CSVFeederService } from './csv-feeder-service';

@Component({
  selector: 'app-csv-feeder',
  templateUrl: './csv-feeder.component.html',
  styleUrls: ['./csv-feeder.component.css'],
})
export class CsvFeederComponent implements OnInit {
  @ViewChild('fileUploader') fileUploader?: any;
  uploadedFiles: Array<File> = [];
  uploadObs = new Observable<{ id: string }>();
  getProgressObs = new Observable<any>();

  spinner = false;
  isProgress = false;
  progress = 0;
  progressIntervel!: any;

  constructor(
    private http: HttpClient,
    private csvUploadService: CSVFeederService
  ) {}

  ngOnInit(): void {
    const progressKey = localStorage.getItem('progress_key');
    if (progressKey) {
      this.getProgress(progressKey);
    }
  }

  onSubmit(): void {
    if (this.uploadedFiles.length < 1) {
      return;
    }
    this.spinner = true;
    this.uploadObs = this.csvUploadService.uploadCsv(this.uploadedFiles[0]);
    this.subscribeToUploadedFile();
  }

  subscribeToUploadedFile() {
    let uploadObs = this.uploadObs;

    uploadObs.subscribe(
      (data) => {
        this.spinner = false;
        this.uploadedFiles = [];

        this.getProgress(data.id);
      },
      (error) => {
        this.spinner = false;
      }
    );
  }

  getProgress(key: string) {
    this.spinner = true;
    this.isProgress = true;

    this.saveProgressToken(key);

    this.progressIntervel = setInterval(() => {
      if (this.progress === 100) {
        this.clearProgressCheck();
        this.removeProgressToken();
      }
      this.getProgressObs = this.csvUploadService.getProgress(key);
      this.subscribeToProgress();
    }, 1000);
  }

  subscribeToProgress() {
    this.getProgressObs.subscribe(
      (data) => {
        this.spinner = false;

        if (Object.keys(data).length === 0) {
          return;
        }

        this.progress = data.progress;
      },
      (error) => {
        this.spinner = false;
      }
    );
  }

  saveProgressToken(key: string) {
    localStorage.setItem('progress_key', key);
  }

  removeProgressToken() {
    localStorage.removeItem('progress_key');
  }

  clearProgressCheck() {
    clearInterval(this.progressIntervel);
  }
}
