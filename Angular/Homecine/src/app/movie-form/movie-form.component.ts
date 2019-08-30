import {Component, ElementRef, Input, OnInit, Output, ViewChild, EventEmitter} from '@angular/core';
import {Movie} from '../movie';

@Component({
  selector: 'app-movie-form',
  templateUrl: './movie-form.component.html',
  styleUrls: ['./movie-form.component.css']
})
export class MovieFormComponent implements OnInit {
  @ViewChild('content', { static: false }) tag: ElementRef;
  // tslint:disable-next-line:no-input-rename
  @Input('type') type: string;

  private _model: Movie;

  @Input()
  set model(model: Movie) {
    this._model = model || new Movie();
  }

  get model(): Movie { return this._model; }

  // tslint:disable-next-line:no-output-on-prefix
  @Output() onSubmitted = new EventEmitter<boolean>();

  submitBtn: string;

  constructor() { }

  ngOnInit() {
    this.submitBtn = this.type === 'edit' ? 'Edit movie' : 'Create movie';
  }

  onSubmit() {
    this.onSubmitted.emit(true);
  }
}
