import { Component, OnInit } from '@angular/core';
import {Movie} from '../movie';
import {ActivatedRoute, Router} from '@angular/router';
import {MovieService} from '../movie.service';

@Component({
  selector: 'app-movie-edit',
  templateUrl: './movie-edit.component.html',
  styleUrls: ['./movie-edit.component.css']
})
export class MovieEditComponent implements OnInit {

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

  updateMovie(): void {
    this.movieService.updateMovieById(this.movie.id, this.movie)
      .subscribe(note => {
        this.router.navigate(['/movie/show/' + this.movie.id]);
      });
  }

  onSubmit(submitted: boolean): void {
    if (submitted) {
      return this.updateMovie();
    }
    return;
  }

}
