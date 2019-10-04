import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';
import { NgbdAccordionBasic } from './accordion.component';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';


const routes: Routes = [{
	path: '',
	data: {
      title: 'Accordion page',
      urls: [{title: 'Dashboard', url: '/'},{title: 'Angular Component'},{title: 'Accordion page'}]
    },
	component: NgbdAccordionBasic
}];

@NgModule({
	imports: [
    	FormsModule,
    	CommonModule, 
      NgbModule.forRoot(),
    	RouterModule.forChild(routes)
    ],
	declarations: [NgbdAccordionBasic]
})
export class AccordionModule { }
