import { Component, OnInit } from '@angular/core';
import {Movie} from '../movie';
import {ActivatedRoute} from '@angular/router';
import {MovieService} from '../movie.service';

@Component({
  selector: 'app-movies',
  templateUrl: './movies.component.html',
  styleUrls: ['./movies.component.css']
})
export class MoviesComponent implements OnInit {

  movies: Movie[] = [];

  constructor(private route: ActivatedRoute, private movieService: MovieService) { }

  ngOnInit() {
    this.getMovies();
  }

  getMovies() {
    this.movieService.getAllMovies().subscribe((movies) => this.movies = movies);
  }

  deleteMovie(id: number): void {
    this.movieService.deleteMovieById(id)
      .subscribe(_ => {
        this.getMovies();
      });
  }
}
