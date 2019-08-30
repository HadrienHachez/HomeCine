import { Component, OnInit } from '@angular/core';
import {Movie} from '../movie';
import {ActivatedRoute, Router} from '@angular/router';
import {MovieService} from '../movie.service';

@Component({
  selector: 'app-movie-show',
  templateUrl: './movie-show.component.html',
  styleUrls: ['./movie-show.component.css']
})
export class MovieShowComponent implements OnInit {

  movie: Movie = null;

  constructor(private route: ActivatedRoute,
              private movieService: MovieService,
              private router: Router) { }

  ngOnInit() {
    this.getMovie();
  }

  getMovie(): void {
    const id = +this.route.snapshot.paramMap.get('id');
    this.movieService.getMovieById(id)
      .subscribe(movie => this.movie = movie);
  }
}
