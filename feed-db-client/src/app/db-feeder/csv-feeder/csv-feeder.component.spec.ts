import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CsvFeederComponent } from './csv-feeder.component';

describe('CsvFeederComponent', () => {
  let component: CsvFeederComponent;
  let fixture: ComponentFixture<CsvFeederComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CsvFeederComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CsvFeederComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
