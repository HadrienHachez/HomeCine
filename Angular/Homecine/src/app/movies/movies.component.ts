import { Component, OnInit } from '@angular/core';
import {MOVIES} from "../mock-movies";

@Component({
  selector: 'app-movies',
  templateUrl: './movies.component.html',
  styleUrls: ['./movies.component.css']
})
export class MoviesComponent implements OnInit {
  movies = MOVIES;
  constructor() { }

  ngOnInit() {

  }
}
