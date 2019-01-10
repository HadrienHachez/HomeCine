import { Component, OnInit } from '@angular/core';
import {ActivatedRoute, NavigationExtras, Router} from "@angular/router";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  q: string;

  ngOnInit() {
  }
  constructor(private route: ActivatedRoute,
              private router: Router) { }

  search(): void {
    let navigationExtras: NavigationExtras = {
      queryParams: { 'q': this.q},
      fragment: 'search'
    };
    this.router.navigate(["/", navigationExtras]);
  }

}