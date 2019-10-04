import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';
import { NgbdDatepickerBasic  } from './datepicker.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
 
const routes: Routes = [{
	path: '',
	data: {
      title: 'Datepicker page',
      urls: [{title: 'Dashboard', url: '/'},{title: 'Angular Component'},{title: 'Datepicker page'}]
    },
	component: NgbdDatepickerBasic  
}];

@NgModule({
	imports: [
    	FormsModule,
    	CommonModule,
       
      NgbModule.forRoot(),
    	RouterModule.forChild(routes)
    ],
	declarations: [NgbdDatepickerBasic ]
})
export class DatepickerModule { }
