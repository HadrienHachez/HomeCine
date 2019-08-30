import {Component, ElementRef, EventEmitter, Input, OnInit, Output, ViewChild} from '@angular/core';
import {Movie} from '../movie';
import {MovieService} from '../movie.service';
import {Note} from '../note';

@Component({
  selector: 'app-note-form',
  templateUrl: './note-form.component.html',
  styleUrls: ['./note-form.component.css']
})
export class NoteFormComponent implements OnInit {

  @ViewChild('content', { static: false }) tag: ElementRef;
  // tslint:disable-next-line:no-input-rename
  @Input('type') type: string;

  private _model: Note;

  @Input()
  set model(model: Note) {
    this._model = model || new Note();
  }

  get model(): Note { return this._model; }

  // tslint:disable-next-line:no-output-on-prefix
  @Output() onSubmitted = new EventEmitter<boolean>();

  movies: Movie[] = [];
  submitBtn: string;
  selectedText: string;

  constructor(private movieService: MovieService) { }

  ngOnInit() {
    this.submitBtn = this.type === 'edit' ? 'Edit note' : 'Create note';
    this.getMovies();
  }

  getMovies(): void {
    this.movieService.getAllMovies()
      .subscribe(movies => this.movies = movies);
  }

  onSubmit() {
    this.onSubmitted.emit(true);
  }

}
