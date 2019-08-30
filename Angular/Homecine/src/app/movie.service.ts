import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Movie} from './movie';
import {catchError, tap} from 'rxjs/operators';
import {Observable, of} from 'rxjs';
import {MessageService} from './message.service';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class MovieService {
  private moviesUrl = 'http://localhost:8000/api/movie/';  // URL to web api

  movies: Movie[] = [];

  constructor(private http: HttpClient, private messageService: MessageService) {}

  /** Log a CategoryService message with the MessageService */
  private log(message: string) {
    this.messageService.add('MovieService: ' + message);
  }

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      console.error(error); // log to console instead

      // TODO: better job of transforming error for user consumption
      this.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }



  // DELETE movie by id from the server
  deleteMovieById(movie: Movie | number): Observable<Movie> {
    const id = typeof movie === 'number' ? movie : movie.id;
    const url = `${this.moviesUrl}${id}`;

    return this.http.delete<Movie>(url, httpOptions)
      .pipe(
        tap(_ => this.log(`deleted movie id=${id}`)),
        catchError(this.handleError<Movie>('deleteMovieById'))
      );
  }


  // GET all the movies from the server
  getAllMovies(): Observable<Movie[]> {
    return this.http.get<Movie[]>(this.moviesUrl)
      .pipe(
        tap(_ => this.log(`fetched movies`)),
        catchError(this.handleError('getAllMovies', []))
      );
  }

  // GET movie by id. Will 404 if id not found
  getMovieById(id: number): Observable<Movie> {
    const url = `${this.moviesUrl}${id}`;
    return this.http.get<Movie>(url)
      .pipe(
        tap(_ => this.log(`fetched movie id=${id}`)),
        catchError(this.handleError<Movie>(`getMovieById id=${id}`))
      );
  }
  // PUT update the movie on the server
  updateMovieById(id: number, movie: Movie): Observable<any> {
    const url = `${this.moviesUrl}${id}`;
    return this.http.put(url, movie, httpOptions).pipe(
      tap(_ => this.log(`updated movie id=${movie.id}`)),
      catchError(this.handleError<any>('updateMovieById'))
    );
  }

  // POST create a new movie on the server
  addMovie(movie: Movie): Observable<Movie> {
    return this.http.post<Movie>(this.moviesUrl, movie, httpOptions)
      .pipe(
        tap((newMovie: Movie) => this.log(`added movie w/ id=${newMovie.id}`)),
        catchError(this.handleError<Movie>('addMovie'))
      );
  }
}
