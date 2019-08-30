import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {HomeComponent} from './home/home.component';
import {MoviesComponent} from './movies/movies.component';
import {NotesComponent} from './notes/notes.component';
import {SearchComponent} from './search/search.component';
import {MovieEditComponent} from './movie-edit/movie-edit.component';
import {MovieCreateComponent} from './movie-create/movie-create.component';
import {MovieShowComponent} from './movie-show/movie-show.component';
import {NoteEditComponent} from './note-edit/note-edit.component';
import {NoteNewComponent} from './note-new/note-new.component';

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'movie', component: MoviesComponent },
  { path: 'movie/show/:id', component: MovieShowComponent },
  { path: 'movie/edit/:id', component: MovieEditComponent },
  { path: 'movie/create', component: MovieCreateComponent },
  { path: 'note', component: NotesComponent },
  { path: 'note/edit/:id', component: NoteEditComponent },
  { path: 'note/new', component: NoteNewComponent },
  { path: 'search', component: SearchComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
