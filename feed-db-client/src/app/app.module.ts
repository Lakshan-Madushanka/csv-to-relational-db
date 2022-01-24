import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { LoadingBarRouterModule } from '@ngx-loading-bar/router';
import { AppRoutingsModule } from 'src/app-routing-module';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FileUploadModule } from '@iplab/ngx-file-upload';

import { AppComponent } from './app.component';
import { CsvFeederComponent } from './db-feeder/csv-feeder/csv-feeder.component';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { ProgressBarComponent } from './shared/components/progress-bar/progress-bar.component';

@NgModule({
  declarations: [AppComponent, CsvFeederComponent, ProgressBarComponent],
  imports: [
    BrowserModule,
    AppRoutingsModule,
    LoadingBarRouterModule,
    BrowserAnimationsModule,
    FormsModule,
    HttpClientModule,
    FileUploadModule,
    BrowserAnimationsModule,
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
