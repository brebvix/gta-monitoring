import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';
import { NgbdratingBasic } from './rating.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

const routes: Routes = [{
	path: '',
	data: {
      title: 'Rating page',
      urls: [{title: 'Dashboard', url: '/'},{title: 'Angular Component'},{title: 'Rating page'}]
    },
	component: NgbdratingBasic
}];

@NgModule({
	imports: [
    	FormsModule,
    	CommonModule,
      ReactiveFormsModule,
      NgbModule.forRoot(),
    	RouterModule.forChild(routes)
    ],
	declarations: [NgbdratingBasic]
})
export class RatingModule { }
