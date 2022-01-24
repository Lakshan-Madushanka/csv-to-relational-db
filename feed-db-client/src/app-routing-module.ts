import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { CsvFeederComponent } from './app/db-feeder/csv-feeder/csv-feeder.component';

const appRoutes: Routes = [
  {
    path: '',
    redirectTo: '/upload-csv',
    pathMatch: 'full',
  },
  { path: 'upload-csv', component: CsvFeederComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(appRoutes)],
  exports: [RouterModule],
})
export class AppRoutingsModule {}
