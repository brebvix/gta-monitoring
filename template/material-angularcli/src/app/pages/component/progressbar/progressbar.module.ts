import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';
import { NgbdpregressbarBasic } from './progressbar.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
 
const routes: Routes = [{
	path: '',
	data: {
      title: 'Progressbar page',
      urls: [{title: 'Dashboard', url: '/'},{title: 'Angular Component'},{title: 'Progressbar page'}]
    },
	component: NgbdpregressbarBasic
}];

@NgModule({
	imports: [
    	FormsModule,
    	CommonModule,
      
      NgbModule.forRoot(),
    	RouterModule.forChild(routes)
    ],
	declarations: [NgbdpregressbarBasic]
})
export class progressbarModule { }
