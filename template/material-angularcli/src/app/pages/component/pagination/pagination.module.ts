import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';
import { NgbdpaginationBasic } from './pagination.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
 
const routes: Routes = [{
	path: '',
	data: {
      title: 'Pagination page',
      urls: [{title: 'Dashboard', url: '/'},{title: 'Angular Component'},{title: 'Pagination page'}]
    },
	component: NgbdpaginationBasic
}];

@NgModule({
	imports: [
    	FormsModule,
    	CommonModule,
      
      NgbModule.forRoot(),
    	RouterModule.forChild(routes)
    ],
	declarations: [NgbdpaginationBasic]
})
export class paginationModule { }
