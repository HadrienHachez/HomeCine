import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms'; // <-- NgModel lives here

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import {AppRoutingModule} from './app-routing.module';
import { NavbarComponent } from './navbar/navbar.component';
import { MoviesComponent } from './movies/movies.component';
import { NotesComponent } from './notes/notes.component';
import { SearchComponent } from './search/search.component';
import { MovieEditComponent } from './movie-edit/movie-edit.component';
import { MovieCreateComponent } from './movie-create/movie-create.component';
import {MessageService} from './message.service';
import {MovieService} from './movie.service';
import {HttpClientModule} from '@angular/common/http';
import { MovieShowComponent } from './movie-show/movie-show.component';
import { MovieFormComponent } from './movie-form/movie-form.component';
import { NoteEditComponent } from './note-edit/note-edit.component';
import { NoteNewComponent } from './note-new/note-new.component';
import { NoteFormComponent } from './note-form/note-form.component';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    NavbarComponent,
    MoviesComponent,
    NotesComponent,
    SearchComponent,
    MovieEditComponent,
    MovieCreateComponent,
    MovieShowComponent,
    MovieFormComponent,
    NoteEditComponent,
    NoteNewComponent,
    NoteFormComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    AppRoutingModule
  ],
  providers: [MessageService, MovieService],
  bootstrap: [AppComponent]
})
export class AppModule { }
