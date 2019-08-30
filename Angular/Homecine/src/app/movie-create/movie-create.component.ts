import { Component, OnInit } from '@angular/core';
import {Movie} from '../movie';
import {ActivatedRoute, Router} from '@angular/router';
import {MovieService} from '../movie.service';

@Component({
  selector: 'app-movie-create',
  templateUrl: './movie-create.component.html',
  styleUrls: ['./movie-create.component.css']
})
export class MovieCreateComponent implements OnInit {

  movie: Movie;

  constructor(private route: ActivatedRoute,
              private movieService: MovieService,
              private router: Router) { }

  ngOnInit() {
    this.movie = new Movie();
  }

  addMovie(): void {
    this.movieService.addMovie(this.movie)
      .subscribe(movie => {
        this.router.navigate(['/movie/show/' + movie.id]);
      });
  }

  onSubmit(submitted: boolean): void {
    if (submitted) {
      return this.addMovie();
    }
    return;
  }

}
